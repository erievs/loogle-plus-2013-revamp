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

function isValidDate($date) {
    $d = DateTime::createFromFormat('Y-m-d', $date);
    return $d && $d->format('Y-m-d') === $date;
}

function saveOrUpdateUserInfo($data) {
    global $conn;

    $username = $data['username'];
    $gender = $data['gender'] ?? null;
    $networking = $data['networking'] ?? null;
    $birthday = isset($data['birthday']) && isValidDate($data['birthday']) ? $data['birthday'] : null;
    $relationship = $data['relationship'] ?? null;
    $othernames = $data['othernames'] ?? null;
    $tagline = $data['tagline'] ?? null;
    $introduction = $data['introduction'] ?? null;
    $bragging_rights = $data['bragging_rights'] ?? null;

    $setClause = [];
    $params = [];
    $types = '';

    if ($gender !== null) {
        $setClause[] = "gender = ?";
        $params[] = $gender;
        $types .= 's';
    }
    if ($networking !== null) {
        $setClause[] = "networking = ?";
        $params[] = $networking;
        $types .= 's';
    }
    if ($birthday !== null) {
        $setClause[] = "birthday = ?";
        $params[] = $birthday;
        $types .= 's';
    }
    if ($relationship !== null) {
        $setClause[] = "relationship = ?";
        $params[] = $relationship;
        $types .= 's';
    }
    if ($othernames !== null) {
        $setClause[] = "othernames = ?";
        $params[] = $othernames;
        $types .= 's';
    }
    if ($tagline !== null) {
        $setClause[] = "tagline = ?";
        $params[] = $tagline;
        $types .= 's';
    }
    if ($introduction !== null) {
        $setClause[] = "introduction = ?";
        $params[] = $introduction;
        $types .= 's';
    }
    if ($bragging_rights !== null) {
        $setClause[] = "bragging_rights = ?";
        $params[] = $bragging_rights;
        $types .= 's';
    }


    if (empty($setClause)) {
        return array('status' => 'error', 'message' => 'No fields to update');
    }

    $setClauseString = implode(', ', $setClause);
    $query = "UPDATE about_user SET $setClauseString WHERE username = ?";
    $params[] = $username;
    $types .= 's';

    $stmt = $conn->prepare($query);
    $stmt->bind_param($types, ...$params);

    if ($stmt->execute()) {
        return array('status' => 'success', 'message' => 'User information updated successfully');
    } else {
        return array('status' => 'error', 'message' => 'Failed to update user information');
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' || $_SERVER['REQUEST_METHOD'] === 'PUT') {
    $input = json_decode(file_get_contents('php://input'), true);

    if (isset($input['username'])) {
        $response = saveOrUpdateUserInfo($input);
    } else {
        $response = array('status' => 'error', 'message' => 'Username is required');
    }

    echo json_encode($response);
} else {
    echo json_encode(array('status' => 'error', 'message' => 'Invalid request method'));
}

$conn->close();
?>
