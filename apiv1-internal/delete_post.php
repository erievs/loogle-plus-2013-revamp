<?php
session_start();
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

$isCommandLine = php_sapi_name() === 'cli';
$response = array();

include("../important/db.php");

function deletePost($postId) {
    global $db_host, $db_user, $db_pass, $db_name;

    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

    if ($conn->connect_error) {
        $response['status'] = 'error';
        $response['message'] = "Connection failed: " . $conn->connect_error;
        return $response;
    }

    $conn->query("SET FOREIGN_KEY_CHECKS = 0");

    $checkQuery = "SELECT id FROM posts WHERE id = ?";
    $checkStmt = $conn->prepare($checkQuery);
    $checkStmt->bind_param("i", $postId);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();

    if ($checkResult->num_rows > 0) {
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
        $response['message'] = 'Post does not exist with ID: ' . $postId;
    }

    $checkStmt->close();
    $conn->close();

    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
    $conn->query("SET FOREIGN_KEY_CHECKS = 1");
    $conn->close();

    return $response;
}

if ($_SERVER['REQUEST_METHOD'] === 'DELETE' || $_SERVER['REQUEST_METHOD'] === 'GET') {
    $postId = isset($_GET['id']) ? $_GET['id'] : '';

    if (empty($postId)) {
        $response['status'] = 'error';
        $response['message'] = 'Invalid request. Missing parameters: id.';
    } else {
        $deleteResponse = deletePost($postId);
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