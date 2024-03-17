<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['username'])) {
    $imageURL = '';

    if (isset($_FILES["postImage"]) && $_FILES["postImage"]["error"] === 0) {
        $targetDir = "assets/images/";
        $randomFilename = uniqid() . "_" . basename($_FILES["postImage"]["name"]);
        $targetFile = $targetDir . $randomFilename;
        if (move_uploaded_file($_FILES["postImage"]["tmp_name"], $targetFile)) {
            $imageURL = $targetFile;
        }
    }

    if (isset($_POST['postContent'])) {
        $postContent = trim($_POST['postContent']);
        $charLimit = 60000;

        if (strlen($postContent) == 0 && empty($imageURL)) {
            $response = array('status' => 'error', 'message' => 'Please enter text or upload an image to post.');
            echo json_encode($response);
            exit;
        } elseif (strlen($postContent) > $charLimit) {
            $response = array('status' => 'error', 'message' => 'Text input must be between 1 and ' . $charLimit . ' characters. This is due to MySQL.');
            echo json_encode($response);
            exit;
        }
    } else {
        $postContent = '';
    }

    $imageLink = $_POST['imageLink'];
    $postLink = $_POST['postLink'];

    include("db.php");

    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $username = $_SESSION['username'];

    // Insert the post into the posts table
    $query = "INSERT INTO posts (username, content, image_url, image_link_url, post_link_url, created_at) VALUES (?, ?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssss", $username, $postContent, $imageURL, $imageLink, $postLink);
    $stmt->execute();

    // Get the auto-generated post ID
    $newPostID = $stmt->insert_id;

    $stmt->close();

    // Create and send notifications to mentioned users
    preg_match_all('/\+([A-Za-z0-9_]+)/', $postContent, $matches);

    if (!empty($matches[1])) {
        foreach ($matches[1] as $mentionedUser) {
            // Create a personalized notification message
            $notificationContent = "Mentioned you in a post!";

            // Insert a notification for each mentioned user
            $query = "INSERT INTO notifications (sender, recipient, content, post_id, created_at) VALUES (?, ?, ?, ?, NOW())";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("sssi", $username, $mentionedUser, $notificationContent, $newPostID);
            $stmt->execute();
            $stmt->close();
        }
    }

    $conn->close();

    $response = array('status' => 'success', 'message' => 'Post successfully submitted.');
    echo json_encode($response);
    exit;
}

$response = array('status' => 'error', 'message' => 'Error submitting the post.');
echo json_encode($response);
?>
