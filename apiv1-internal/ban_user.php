<?php
include("../important/db.php");

$allowed_origin = parse_url($siteurl, PHP_URL_HOST);
$origin = isset($_SERVER['HTTP_ORIGIN']) ? parse_url($_SERVER['HTTP_ORIGIN'], PHP_URL_HOST) : '';
$referer = isset($_SERVER['HTTP_REFERER']) ? parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST) : '';

if ($origin !== $allowed_origin && $referer !== $allowed_origin) {
    http_response_code(403);
    echo json_encode(array('error' => 'Access denied.'));
    exit();
}

$mod_username = $_POST['mod_username'] ?? '';
$user_to_ban = $_POST['user_to_ban'] ?? '';
$ip_address = $_POST['ip_address'] ?? '';
$reason = $_POST['reason'] ?? '';

if (!empty($mod_username) && !empty($user_to_ban) && !empty($reason)) {
    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt1 = $conn->prepare("SELECT username FROM moderators WHERE username = ?");
    $stmt1->bind_param("s", $mod_username);
    $stmt1->execute();
    $stmt1->store_result();

    if ($stmt1->num_rows > 0) {
        $stmt1->close();

        $stmt2 = $conn->prepare("INSERT INTO bans (username, ip_address, reason) VALUES (?, ?, ?)");
        $stmt2->bind_param("sss", $user_to_ban, $ip_address, $reason);
        $stmt2->execute();
        $stmt2->close();

        echo "User $user_to_ban has been banned successfully.";
    } else {
        $stmt1->close();
        echo "Unauthorized: The user making the request is not a moderator.";
    }

    $conn->close();
} else {
    echo "Mod username, user to ban, and reason are required.";
}
?>