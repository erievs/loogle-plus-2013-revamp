<?php

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

include("../important/db.php");

$allowed_origin = parse_url($siteurl, PHP_URL_HOST);
$origin = isset($_SERVER['HTTP_ORIGIN']) ? parse_url($_SERVER['HTTP_ORIGIN'], PHP_URL_HOST) : '';
$referer = isset($_SERVER['HTTP_REFERER']) ? parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST) : '';

if ($origin !== $allowed_origin && $referer !== $allowed_origin) {
    http_response_code(403); 
    echo json_encode(array('error' => 'Access denied.'));
    exit();
}

session_start();

if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
    http_response_code(403);
    echo json_encode(array('error' => 'Unauthorized access. Please log in.'));
    exit();
}

$username = $_SESSION['username'];

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$stmt = $conn->prepare("SELECT COUNT(*) AS count FROM moderators WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if ($row['count'] == 0) {
    http_response_code(403);
    echo json_encode(array('error' => 'Access denied. User is not a moderator.'));
    exit();
}

function getIPsFromDatabase() {
    include("../important/db.php");
    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $query = "SELECT id, username, ip_address FROM ips ORDER BY id DESC";
    $result = $conn->query($query);
    $ips = array();

    if ($result->num_rows > 0) {
        while ($ip = $result->fetch_assoc()) {
            $ips[] = array(
                'id' => $ip['id'],
                'username' => $ip['username'],
                'ip_address' => $ip['ip_address']
            );
        }
    }

    $conn->close();

    return $ips;
}

$ipsData = getIPsFromDatabase();
echo json_encode($ipsData);

?>