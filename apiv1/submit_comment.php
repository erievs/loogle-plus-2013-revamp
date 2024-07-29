<?php
session_start();

header("Content-Type: application/json");

$response = array();

$rateLimit = 2.5;

function isRateLimited($rateLimitFile, $rateLimit) {
    if (!file_exists($rateLimitFile) || (time() - filemtime($rateLimitFile)) > $rateLimit) {
        touch($rateLimitFile);
        return false;
    } else {
        return true;
    }
}

$rateLimitFile = sys_get_temp_dir() . '/' . 'ratelimit_comments.txt';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $commentContent = $_POST['commentContent'] ?? '';
    $postID = $_POST['postID'] ?? '';
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($commentContent) || empty($postID) || empty($username) || empty($password)) {
        $response['status'] = 'error';
        $response['message'] = 'All fields are required';
        echo json_encode($response);
        exit();
    }

    if (trim($commentContent) === '') {
        $response['status'] = 'error';
        $response['message'] = 'Comment cannot consist only of spaces';
        echo json_encode($response);
        exit();
    }

    include("../important/db.php");

    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

    if ($conn->connect_error) {
        $response['status'] = 'error';
        $response['message'] = "Connection failed: " . $conn->connect_error;
        echo json_encode($response);
        exit();
    }

    $query = "SELECT * FROM users WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        $response['status'] = 'error';
        $response['message'] = 'Invalid username or password';
        $stmt->close();
        $conn->close();
        echo json_encode($response);
        exit();
    }

    $query = "INSERT INTO comments (post_id, username, comment_content, created_at) VALUES (?, ?, ?, NOW())";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iss", $postID, $username, $commentContent);

    if ($stmt->execute()) {
        $commentId = $conn->insert_id;
        $response['status'] = 'success';
        $response['message'] = 'Comment successfully added';
        $response['commentContent'] = $commentContent;
        $response['postID'] = $postID;
        $response['commentID'] = $commentId;
        $response['username'] = $username;
    } else {
        $response['status'] = 'error';
        $response['message'] = "Error: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
} else {
    $response['status'] = 'error';
    $response['message'] = 'Invalid request method';
}
