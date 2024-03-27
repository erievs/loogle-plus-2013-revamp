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
if (isRateLimited($rateLimitFile, $rateLimit)) {
    $response['status'] = 'error';
    $response['message'] = "Error: You can only comment once every $rateLimit second(s).";
    echo json_encode($response);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $commentContent = $_POST['commentContent'];
    $postID = $_POST['postID'];
    $username = $_POST['username'];

    if (empty($commentContent)) {
        $response['status'] = 'error';
        $response['message'] = 'Comment content cannot be blank';
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
    } else {
        $query = "INSERT INTO comments (post_id, username, comment_content) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("iss", $postID, $username, $commentContent);

        if ($stmt->execute()) {
            $response['status'] = 'success';
            $response['message'] = 'Comment successfully added';
            $response['commentContent'] = $commentContent;
            $response['postID'] = $postID;
            $response['username'] = $username;
        } else {
            $response['status'] = 'error';
            $response['message'] = "Error: " . $conn->error;
        }

        $stmt->close();
        $conn->close();
    }
} else {
    $response['status'] = 'error';
    $response['message'] = 'Invalid request method';
}

echo json_encode($response);
?>
