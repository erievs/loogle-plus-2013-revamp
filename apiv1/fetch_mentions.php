<?php
session_start();

if (isset($_SESSION['username']) && isset($_GET['username'])) {
    include("../important/db.php");


    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $username = $_GET['username'];

    $query = "SELECT post_id, sender, content, created_at FROM notifications WHERE recipient = ? AND read_status = 0 ORDER BY created_at DESC";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    $mentions = [];

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $mentions[] = $row;
        }
    }

    $stmt->close();

    echo json_encode($mentions);

    $conn->close();
}
?>
