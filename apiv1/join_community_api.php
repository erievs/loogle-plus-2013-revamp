<?php
session_start();

header("Content-Type: application/json");

$response = array();

$request_data = file_get_contents('php://input');
$request_params = json_decode($request_data, true);
error_log('Received POST request with data: ' . print_r($request_params, true));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($request_params['community_id']) && isset($request_params['username'])) {
        $community_id = $request_params['community_id'];
        $username = $request_params['username'];

        include("../important/db.php");

        error_log('Connecting to database with host: ' . $db_host . ', user: ' . $db_user . ', name: ' . $db_name);

        $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

        if ($conn->connect_error) {

            $response['status'] = 'error';
            $response['message'] = "Connection failed: " . $conn->connect_error;
        } else {

            $formatted_username = ",$username:member";

            $query = "UPDATE communities SET members_list = CONCAT(members_list, ?), members = members + 1 WHERE community_id = ?";
            error_log('Executing query: ' . $query);

            $stmt = $conn->prepare($query);

            $stmt->bind_param("si", $formatted_username, $community_id);

            if ($stmt->execute()) {

                $response['status'] = 'success';
                $response['message'] = 'You have successfully joined the community';
            } else {

                $response['status'] = 'error';
                $response['message'] = 'Failed to join the community';
            }

            $stmt->close();
            $conn->close();
        }
    } else {

        $response['status'] = 'error';
        $response['message'] = 'Missing parameters: community_id or username';
    }
} else {

    $response['status'] = 'error';
    $response['message'] = 'Invalid request method';
}

error_log('Response: ' . json_encode($response));

echo json_encode($response);
?>