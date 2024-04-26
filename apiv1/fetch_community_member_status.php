<?php

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

function fetchCommunityMemberStatus($community_id, $username) {
    include("../important/db.php");
    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $query = "SELECT members_list, creator_username FROM communities WHERE community_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $community_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $memberStatus = 'not_member';

    if ($result->num_rows > 0) {
        $community = $result->fetch_assoc();
        $membersList = explode(',', $community['members_list']);
        foreach ($membersList as $member) {
            list($memberUsername, $role) = explode(':', $member);
            if ($memberUsername === $username) {
                if ($role === 'owner') {
                    $memberStatus = 'owner';
                } else {
                    $memberStatus = 'member';
                }
                break;
            }
        }
        if ($community['creator_username'] === $username) {
            $memberStatus = 'owner';
        }
    }

    $stmt->close();
    $conn->close();

    return $memberStatus;
}

if (isset($_GET['community_id']) && isset($_GET['username'])) {
    $community_id = $_GET['community_id'];
    $username = $_GET['username'];
    $memberStatus = fetchCommunityMemberStatus($community_id, $username);
    echo json_encode(array('member_status' => $memberStatus));
} else {
    echo json_encode(array('error' => 'Missing community_id or username'));
}
?>
