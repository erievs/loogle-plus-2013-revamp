<?php
session_start();
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
$isCommandLine = php_sapi_name() === 'cli';

$rateLimit = 2.5;

$response = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST' || $isCommandLine) {
    if ($isCommandLine) {
        $username = $_POST['username'] ?? ''; // Instead of username
        $postContent = $_POST['postContent'] ?? ''; // Instead of postContent
    } else {
        $username = $_POST['username'] ?? ''; // Assuming it's sent as 'username'
        $postContent = $_POST['postContent'] ?? '';
    }

    include("../important/db.php");
    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

    if ($conn->connect_error) {
        $response['status'] = 'error';
        $response['message'] = "Connection failed: " . $conn->connect_error;
    } else {
        $imageURL = '';

        // Check if the 'postImage' key exists in $_FILES
        if (isset($_FILES["postImage"]) && $_FILES["postImage"]["error"] === 0) {
            $targetDir = "../assets/images/";
            $randomFilename = uniqid() . "_" . basename($_FILES["postImage"]["name"]);
            $targetFile = $targetDir . $randomFilename;
            if (move_uploaded_file($_FILES["postImage"]["tmp_name"], $targetFile)) {
                $imageURL = $targetFile;
            } else {
                $response['status'] = 'error';
                $response['message'] = "Failed to move uploaded file.";
                echo json_encode($response);
                exit;
            }
        }

        $query = "INSERT INTO posts (username, content, image_url, created_at) VALUES (?, ?, ?, NOW())";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sss", $username, $postContent, $imageURL);
        $stmt->execute();

        $stmt->close();
        $conn->close();

        $response['status'] = 'success';
        $response['message'] = 'Post successfully submitted.';
    }
}

if (!$isCommandLine) {
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>

