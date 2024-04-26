<?php
session_start();

if (isset($_SESSION['username']) && isset($_POST['username'])) {

    include("../important/db.php");
    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['fetch_plus_one']) && isset($_GET['id'])) {
        $postId = $_GET['id'];
        $sql = "SELECT plus_one FROM posts WHERE id = $postId";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $plusOneCount = $row['plus_one'];

            $responseText = "+($plusOneCount)";
            echo json_encode(array("plus_one_text" => $responseText));
        } else {
            http_response_code(404);
            echo json_encode(array("error" => "Post not found"));
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_plus_one']) && isset($_POST['id'])) {
        $postId = $_POST['id'];
        $username = $_POST['username'];

        $sqlCheck = "SELECT plus_one_usernames FROM posts WHERE id = $postId";
        $resultCheck = $conn->query($sqlCheck);

        if ($resultCheck->num_rows > 0) {
            $row = $resultCheck->fetch_assoc();
            $plusOneUsernames = json_decode($row['plus_one_usernames'], true);

            if ($plusOneUsernames === null) {
                $plusOneUsernames = [];
            }

            // Check if username is already in the array
            $index = array_search($username, $plusOneUsernames);
            if ($index !== false) {
                // Remove username and subtract 1 from plus one count
                unset($plusOneUsernames[$index]);
                $sqlUpdate = "UPDATE posts SET plus_one = plus_one - 1, plus_one_usernames = '" . json_encode($plusOneUsernames) . "' WHERE id = $postId";
            } else {
                // Add username and add 1 to plus one count
                $plusOneUsernames[] = $username;
                $sqlUpdate = "UPDATE posts SET plus_one = plus_one + 1, plus_one_usernames = '" . json_encode($plusOneUsernames) . "' WHERE id = $postId";
            }

            if ($conn->query($sqlUpdate) === TRUE) {
                echo json_encode(array("message" => "Plus one updated successfully"));
            } else {
                http_response_code(500);
                echo json_encode(array("error" => "Error updating plus one count: " . $conn->error));
            }
        } else {
            http_response_code(404);
            echo json_encode(array("error" => "Post not found"));
        }
    }

    $conn->close();
} else {
    http_response_code(403);
    echo json_encode(array("error" => "Unauthorized access"));
}
?>
