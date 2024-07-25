<?php
session_start();
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: GET, DELETE, OPTIONS");

$isCommandLine = php_sapi_name() === 'cli';
$response = array();

include("../important/db.php");

function deletePost($postId, $sessionUsername) {
    global $db_host, $db_user, $db_pass, $db_name;

    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

    if ($conn->connect_error) {
        $response['status'] = 'error';
        $response['message'] = "Connection failed: " . $conn->connect_error;
        return $response;
    }

    $conn->query("SET FOREIGN_KEY_CHECKS = 0");

    $checkQuery = "SELECT username FROM posts WHERE id = ?";
    $checkStmt = $conn->prepare($checkQuery);
    $checkStmt->bind_param("i", $postId);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();

    if ($checkResult->num_rows > 0) {
        $post = $checkResult->fetch_assoc();
        $postUsername = $post['username'];

        if ($sessionUsername === $postUsername || isUserModerator($sessionUsername)) {
            $deleteQuery = "DELETE FROM posts WHERE id = ?";
            $deleteStmt = $conn->prepare($deleteQuery);
            $deleteStmt->bind_param("i", $postId);

            if ($deleteStmt->execute()) {
                $response['status'] = 'success';
                $response['message'] = 'Post successfully deleted.';
            } else {
                if ($conn->errno == 1451) { 
                    $response['status'] = 'warning';
                    $response['message'] = 'Post cannot be deleted due to foreign key constraints.';
                } else {
                    $response['status'] = 'error';
                    $response['message'] = 'Error deleting post: ' . $conn->error;
                }
            }

            $deleteStmt->close();
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Unauthorized: You do not have permission to delete this post.';
        }

        $checkStmt->close();
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Post does not exist with ID: ' . $postId;
    }

    $conn->close();

    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
    $conn->query("SET FOREIGN_KEY_CHECKS = 1");
    $conn->close();

    return $response;
}

function isUserModerator($username) {
    global $db_host, $db_user, $db_pass, $db_name;

    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

    if ($conn->connect_error) {
        return false;
    }

    $query = "SELECT username FROM moderators WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    $isModerator = $stmt->num_rows > 0;
    $stmt->close();
    $conn->close();

    return $isModerator;
}

if ($_SERVER['REQUEST_METHOD'] === 'DELETE' || $_SERVER['REQUEST_METHOD'] === 'GET') {
    $postId = isset($_GET['id']) ? $_GET['id'] : '';
    $sessionUsername = $_SESSION['username'] ?? '';  

    if (empty($postId) || empty($sessionUsername)) {
        $response['status'] = 'error';
        $response['message'] = 'Invalid request. Missing parameters: id or session username.';
    } else {
        $deleteResponse = deletePost($postId, $sessionUsername);
        echo json_encode($deleteResponse);
        exit;
    }
}

if (!$isCommandLine) {
    $response['status'] = 'error';
    $response['message'] = 'Invalid request method.';
    echo json_encode($response);
}
?>