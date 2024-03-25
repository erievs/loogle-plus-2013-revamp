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
        $username = $argv[1]; // Instead of username
        $password = $argv[2]; // Instead of password
        $postContent = $argv[3]; // Instead of postContent
    } else {
        $username = $_POST['username']; // Assuming it's sent as 'username'
        $password = $_POST['password']; // Assuming it's sent as 'password'
        $postContent = $_POST['postContent'];
    }

    // Your authentication logic here
    if ($username === 'your_username' && $password === 'your_password') {
        // Authentication successful

        // Your code for rate limiting here
        $rateLimitFile = sys_get_temp_dir() . '/' . 'ratelimit.txt';
        if (!isRateLimited($rateLimitFile, $rateLimit)) {
            // Your code for inserting the post into the database here
            include("../important/db.php");
            $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

            if ($conn->connect_error) {
                $response['status'] = 'error';
                $response['message'] = "Connection failed: " . $conn->connect_error;
            } else {
                $imageURL = ''; // Your code for handling image upload here
                $query = "INSERT INTO posts (username, content, image_url, created_at) VALUES (?, ?, ?, NOW())";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("sss", $username, $postContent, $imageURL);
                $stmt->execute();

                $stmt->close();
                $conn->close();

                $response['status'] = 'success';
                $response['message'] = 'Post successfully submitted.';
            }
        } else {
            $response['status'] = 'error';
            $response['message'] = "Error: You can only post once every $rateLimit second(s).";
        }
    } else {
        // Authentication failed
        $response['status'] = 'error';
        $response['message'] = 'Invalid username or password.';
    }
}

if (!$isCommandLine) {
    header('Content-Type: application/json');
    echo json_encode($response);
}

function isRateLimited($rateLimitFile, $rateLimit) {
    if (!file_exists($rateLimitFile) || (time() - filemtime($rateLimitFile)) > $rateLimit) {
        touch($rateLimitFile);
        return false;
    } else {
        return true;
    }
}
?>

