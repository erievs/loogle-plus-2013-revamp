<?php
session_start();

if (isset($_SESSION['username']) && isset($_POST['username']) && isset($_POST['post_id'])) {
    include("../important/db.php");

    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $postId = $_POST['post_id'];
    $query = "UPDATE notifications SET read_status = 1 WHERE recipient = ? AND post_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $_POST['username'], $postId);
    $stmt->execute();
    $stmt->close();

    $conn->close();
}
?>
