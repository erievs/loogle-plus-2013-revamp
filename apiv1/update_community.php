<?php

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");

function updateCommunity($community_id, $username, $updateFields) {
    include("../important/db.php");
    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

    if ($conn->connect_error) {
        custom_error_log("Connection failed: " . $conn->connect_error); 
        return false; 
    }

    $query = "UPDATE communities SET ";
    $params = array();
    $types = '';
    foreach ($updateFields as $field => $value) {
        if (!empty($value)) {
            $query .= "$field = ?, ";
            $params[] = $value;
            $types .= 's'; // Assuming all values are strings
        }
    }
    if (!empty($params)) {
        $query = rtrim($query, ", ");
        $query .= ", links = ?"; // Add links field to the query
        $params[] = $updateFields['links']; // Add links value to the params array
        $types .= 's'; // Assuming links is a string

        $query .= " WHERE community_id = ?";
        $params[] = $community_id;
        $types .= 'i'; // Assuming community_id is an integer

        $stmt = $conn->prepare($query);
        if (!$stmt) {
            custom_error_log("Query preparation failed: " . $conn->error);
            return false;
        }

        $stmt->bind_param($types, ...$params);
        if (!$stmt->execute()) {
            custom_error_log("Execution failed: " . $stmt->error);
            return false;
        }

        $stmt->close();
        $conn->close();
        return true;
    } else {
        custom_error_log("No update fields provided.");
        $conn->close();
        return false;
    }
}

function custom_error_log($message) {
    $logFile = 'error.log';
    $timestamp = date('Y-m-d H:i:s');
    $logMessage = "[$timestamp] $message\n";
    file_put_contents($logFile, $logMessage, FILE_APPEND);
}

$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON, true);

if ($input === null && json_last_error() !== JSON_ERROR_NONE) {
    custom_error_log("Error decoding JSON: " . json_last_error_msg());
    echo json_encode(array('error' => 'Error decoding JSON.'));
    exit;
}

if (!isset($input['community_id'], $input['username'], $input['updateFields'])) {
    echo json_encode(array('error' => 'Required fields are missing.'));
    exit;
}

$result = updateCommunity($input['community_id'], $input['username'], $input['updateFields']);

if ($result) {
    echo json_encode(array('success' => true));
} else {
    echo json_encode(array('error' => 'Failed to update community information.'));
}

?>
