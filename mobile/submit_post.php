User
<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['username'])) {
    $imageURL = '';

    if ($_FILES["postImage"]["error"] === 0) {
        $targetDir = "..assets/images/";
        $targetFile = $targetDir . basename($_FILES["postImage"]["name"]);
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
            echo '<script>
                    setTimeout(function() {
                        window.history.back();
                    }, 5000); 
                  </script>';
            exit;
        } elseif (strlen($postContent) > $charLimit) {

            $response = array('status' => 'error', 'message' => 'Text input must be between 1 and ' . $charLimit . ' characters. This is due to MySQL.');
            echo json_encode($response);
            echo '<script>
                    setTimeout(function() {
                        window.history.back();
                    }, 5000); 
                  </script>';
            exit;
        }
    } else {
        $postContent = ''; 
    }

    $imageLink = $_POST['imageLink'];
    $postLink = $_POST['postLink'];

    include("../important/db.php");

    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $username = $_SESSION['username'];
    $query = "INSERT INTO posts (username, content, image_url, image_link_url, post_link_url, created_at) VALUES (?, ?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssss", $username, $postContent, $imageURL, $imageLink, $postLink);
    $stmt->execute();

    $stmt->close();
    $conn->close();

    $referer = $_SERVER['HTTP_REFERER'];

    $response = array('status' => 'success', 'message' => 'Post successfully submitted.');
    echo json_encode($response);

    if (!empty($referer)) {
        header("Location: $referer"); 
    } else {
        header("Location: index.php"); 
    }

    exit;
}

$response = array('status' => 'error', 'message' => 'Error submitting the post.');
echo json_encode($response);
?>