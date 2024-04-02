<?php
session_start();

if (isset($_SESSION['username']) && isset($_GET['username'])) {
    include("../important/db.php");

    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $username = $_GET['username'];

    $query = "SELECT COUNT(*) AS total_unread FROM notifications WHERE recipient = ? AND read_status = 0";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    $totalUnread = 0;

    if ($result && $row = $result->fetch_assoc()) {
        $totalUnread = $row['total_unread'];
    }

    $stmt->close();

    echo json_encode(['total_unread' => $totalUnread]);

    $conn->close();
}
?>
