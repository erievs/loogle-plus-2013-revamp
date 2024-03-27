<?php
session_start();

if (isset($_SESSION['username']) && isset($_POST['post_id'])) {
    // Define the database configuration
    $db_host = "localhost";
    $db_user = "root";
    $db_pass = "nicknick";
    $db_name = "plus-foogle";

    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Update the read_status for the post
    $postId = $_POST['post_id'];
    $query = "UPDATE notifications SET read_status = 1 WHERE post_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $postId);
    $stmt->execute();
    $stmt->close();

    $conn->close();
}
?>
