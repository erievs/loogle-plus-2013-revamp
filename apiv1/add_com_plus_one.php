<?php
session_start();
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

include("../important/db.php");

$rateLimit = 2.5;
$response = array();

if (isset($_SESSION['username'])) {
    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

    if ($conn->connect_error) {
        $response['status'] = 'error';
        $response['message'] = "Connection failed: " . $conn->connect_error;
        echo json_encode($response);
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['fetch_plus_one']) && isset($_GET['id'])) {
        $postId = $_GET['id'];
        $sql = "SELECT plus_one FROM posts WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $postId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $plusOneCount = $row['plus_one'];

            $response['status'] = 'success';
            $response['plus_one_text'] = "+($plusOneCount)";
        } else {
            http_response_code(404);
            $response['status'] = 'error';
            $response['message'] = "Post not found";
        }
        $stmt->close();
        echo json_encode($response);
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_plus_one']) && isset($_POST['id']) && isset($_POST['username'])) {
        $postId = $_POST['id'];
        $username = $_POST['username'];

        $rateLimitFile = sys_get_temp_dir() . '/' . 'ratelimit_' . $username . '.txt';
        if (!isRateLimited($rateLimitFile, $rateLimit)) {
            $sqlCheck = "SELECT plus_one, plus_one_usernames FROM posts WHERE id = ?";
            $stmtCheck = $conn->prepare($sqlCheck);
            $stmtCheck->bind_param("i", $postId);
            $stmtCheck->execute();
            $resultCheck = $stmtCheck->get_result();

            if ($resultCheck->num_rows > 0) {
                $row = $resultCheck->fetch_assoc();
                $plusOneUsernames = json_decode($row['plus_one_usernames'], true);

                if ($plusOneUsernames === null) {
                    $plusOneUsernames = [];
                }

                $index = array_search($username, $plusOneUsernames);
                if ($index !== false) {
                    unset($plusOneUsernames[$index]);
                    $sqlUpdate = "UPDATE posts SET plus_one = plus_one - 1, plus_one_usernames = ? WHERE id = ?";
                    $action = "subtracted";
                } else {
                    $plusOneUsernames[] = $username;
                    $sqlUpdate = "UPDATE posts SET plus_one = plus_one + 1, plus_one_usernames = ? WHERE id = ?";
                    $action = "added";
                }

                $stmtUpdate = $conn->prepare($sqlUpdate);
                $plusOneUsernamesJson = json_encode(array_values($plusOneUsernames));
                $stmtUpdate->bind_param("si", $plusOneUsernamesJson, $postId);
                if ($stmtUpdate->execute() === TRUE) {
                    $response['status'] = 'success';
                    $response['message'] = "Plus one updated successfully";
                    $response['action'] = $action;
                } else {
                    http_response_code(500);
                    $response['status'] = 'error';
                    $response['message'] = "Error updating plus one count: " . $conn->error;
                }
                $stmtUpdate->close();
            } else {
                http_response_code(404);
                $response['status'] = 'error';
                $response['message'] = "Post not found";
            }
            $stmtCheck->close();
        } else {
            $response['status'] = 'error';
            $response['message'] = "Error: You can only post once every $rateLimit second(s).";
        }
        echo json_encode($response);
        exit;
    }

    $conn->close();
} else {
    http_response_code(403);
    $response['status'] = 'error';
    $response['message'] = "Unauthorized access";
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
