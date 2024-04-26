<?php
session_start();
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
$isCommandLine = php_sapi_name() === 'cli';

$response = array();

include("../important/db.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' || $isCommandLine) {
    if ($isCommandLine) {
        $name = $argv[1];
        $description = $argv[2];
        $creator_username = $argv[6];
        $members = 1; 
        $members_list = $creator_username . ":owner"; 
        $image_url = $argv[5];
        $display_name = $creator_username;  
    } else {
        $name = isset($_POST['name']) ? $_POST['name'] : '';
        $description = isset($_POST['description']) ? $_POST['description'] : '';
        $creator_username = isset($_POST['creator_username']) ? $_POST['creator_username'] : '';
        $members = 1; 
        $members_list = $creator_username . ":owner"; 
        $image_url = isset($_POST['image_url']) ? $_POST['image_url'] : '';
        $display_name = $creator_username; 
    }

    if (empty($name) || empty($creator_username)) {
        $response['status'] = 'error';
        $response['message'] = 'Invalid request. Missing parameters: name, creator_username.';
        echo json_encode($response);
        exit;
    }

    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

    if ($conn->connect_error) {
        $response['status'] = 'error';
        $response['message'] = "Connection failed: " . $conn->connect_error;
    } else {
        $query = "INSERT INTO communities (name, description, members, members_list, image_url, creator_username, display_name) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssissss", $name, $description, $members, $members_list, $image_url, $creator_username, $display_name);
        $stmt->execute();

        $stmt->close();
        $conn->close();

        if ($isCommandLine) {
            $response['status'] = 'success';
            $response['message'] = "Community successfully created via command line.";
        } else {
            $response['status'] = 'success';
            $response['message'] = 'Community successfully created.';
        }
    }
}

if (!$isCommandLine) {
    $response['status'] = 'error';
    $response['message'] = 'Invalid request or missing parameters.';
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>
