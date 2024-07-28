<?php

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");

function getCommunityById($community_id, $conn) {
    $query = "SELECT * FROM communities WHERE community_id = ?";
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param('i', $community_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return null;
        }
    } else {
        custom_error_log("Query preparation failed: " . $conn->error);
        return null;
    }
}

function updateCommunity($community_id, $updateFields, $conn) {
    $queryParts = array();
    $params = array();
    $types = '';

    foreach ($updateFields as $field => $value) {
        if ($value !== '') {
            $queryParts[] = "$field = ?";
            $params[] = $value;
            $types .= 's'; 
        }
    }

    if (!empty($params)) {
        $query = "UPDATE communities SET " . implode(", ", $queryParts) . " WHERE community_id = ?";
        $params[] = $community_id;
        $types .= 'i'; 

        if ($stmt = $conn->prepare($query)) {
            $stmt->bind_param($types, ...$params);
            $stmt->execute();
            $stmt->close();
            return true;
        } else {
            custom_error_log("Query preparation failed: " . $conn->error);
            return false;
        }
    }

    return true; 
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

include("../important/db.php");
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    custom_error_log("Connection failed: " . $conn->connect_error); 
    echo json_encode(array('success' => false, 'error' => 'Connection failed'));
    exit;
}

$existingData = getCommunityById($input['community_id'], $conn);
if (!$existingData) {
    echo json_encode(array('success' => false, 'error' => 'No record found'));
    $conn->close();
    exit;
}

$updateResult = updateCommunity($input['community_id'], $input['updateFields'], $conn);

if ($updateResult) {

    $responseData = $existingData;

    foreach ($input['updateFields'] as $field => $value) {
        if ($value !== '') {
            $responseData[$field] = $value;
        }
    }

    echo json_encode(array(
        'success' => true,
        'community_id' => $input['community_id'],
        'username' => $input['username'],
        'updateFields' => $responseData
    ), JSON_UNESCAPED_UNICODE);
} else {
    echo json_encode(array('success' => false, 'error' => 'Failed to update community information.'));
}

$conn->close();
?>