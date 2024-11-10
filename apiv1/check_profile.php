<?php
session_start();

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization");

include("../important/db.php");

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

function userExists($conn, $username) {
    $stmt = $conn->prepare("SELECT username FROM user WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    $num_rows = $stmt->num_rows;
    $stmt->close();
    return $num_rows > 0;
}

$profileUsername = isset($_GET['username']) ? $_GET['username'] : '';

if (!empty($profileUsername)) {
    if (userExists($conn, $profileUsername)) {
        echo "true";
    } else {
        echo "false";
    }
} else {
    echo "Profile not found.";
}

$conn->close();
?>
