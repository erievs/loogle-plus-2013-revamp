<?php
session_start();
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: POST");

include("../important/db.php");

$response = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['username'])) {

    if (isset($_POST['id']) && isset($_POST['postContent'])) {
        $postId = $_POST['id'];
        $postContent = $_POST['postContent'];
        $username = $_SESSION['username'];

        $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

        if ($conn->connect_error) {
            $response['status'] = 'error';
            $response['message'] = "Connection failed: " . $conn->connect_error;
            echo json_encode($response);
            exit;
        }

        $stmt = $conn->prepare("SELECT id FROM posts WHERE id = ? AND username = ?");
        $stmt->bind_param("is", $postId, $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {

            $stmt->close();
            $stmt = $conn->prepare("UPDATE posts SET content = ? WHERE id = ?");
            $stmt->bind_param("si", $postContent, $postId);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                $response['status'] = 'success';
                $response['message'] = 'Post updated successfully.';
            } else {
                $response['status'] = 'error';
                $response['message'] = 'Failed to update post. No changes detected or error occurred.';
            }
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Unauthorized action or post not found.';
        }

        $stmt->close();
        $conn->close();

    } else {
        $response['status'] = 'error';
        $response['message'] = 'Invalid request. Missing parameters.';
    }

} else {
    $response['status'] = 'error';
    $response['message'] = 'Unauthorized access. Please log in.';
}

echo json_encode($response);
?>