<?php

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, OPTIONS");

include("../important/db.php");

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function fetchUserInfo($username) {
    global $conn;

    $query = "SELECT * FROM about_user WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $userInfo = $result->fetch_assoc();

        foreach ($userInfo as $key => $value) {
            if ($value === null || $value === '0000-00-00') {
                $userInfo[$key] = 'Unset';
            }
        }

        return array('status' => 'success', 'data' => $userInfo);
    } else {
        return array('status' => 'error', 'message' => 'No user found with the provided username');
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['username'])) {
        $username = $_GET['username'];
        $response = fetchUserInfo($username);
    } else {
        $response = array('status' => 'error', 'message' => 'Username parameter is required');
    }

    echo json_encode($response);
} else {
    echo json_encode(array('status' => 'error', 'message' => 'Invalid request method'));
}

$conn->close();
?>
