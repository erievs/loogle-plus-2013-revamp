<?php

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

function fetchCommunity($community_id) {
    include("../important/db.php");
    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $query = "SELECT * FROM communities WHERE community_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $community_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $communities = array();

    if ($result->num_rows > 0) {
        while ($community = $result->fetch_assoc()) {
            $communities[] = array(
                'community_id' => $community['community_id'],
                'name' => $community['name'],
                'description' => $community['description'],
                'members' => $community['members'],
                'members_list' => $community['members_list'],
                'image_url' => $community['image_url'],
                'creator_username' => $community['creator_username'],
                'display_name' => $community['display_name'],
                'tagline' => $community['tagline'],
                'links' => $community['links'] 
            );
        }
    }

    $stmt->close();
    $conn->close();

    return $communities;
}

if (isset($_GET['community_id'])) {
    $community_id = $_GET['community_id'];
    $communityData = fetchCommunity($community_id);
} else {
    $communityData = array(); 
}

echo json_encode($communityData);
?>
