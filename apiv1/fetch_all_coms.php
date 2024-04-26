<?php

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

function fetchCommunities($username = null) {
    include("../important/db.php");
    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $query = "SELECT * FROM communities";

    if ($username !== null) {
        $query .= " WHERE members_list LIKE '%$username:owner%' OR members_list LIKE '%,{$username}:member%'";
    }

    $result = $conn->query($query);

    $communities = array();

    if ($result->num_rows > 0) {
        while ($community = $result->fetch_assoc()) {
            $community_id = $community['community_id'];
            $members_list = explode(',', $community['members_list']);
            $total_members = count($members_list);
            $total_posts = 0;

            $posts_query = "SELECT COUNT(*) as total_posts FROM communities_posts WHERE community_id = $community_id";
            $posts_result = $conn->query($posts_query);
            if ($posts_result->num_rows > 0) {
                $total_posts = $posts_result->fetch_assoc()['total_posts'];
            }

            $communities[] = array(
                'community_id' => $community_id,
                'name' => $community['name'],
                'description' => $community['description'],
                'members' => $community['members'],
                'members_list' => $community['members_list'],
                'total_members' => $total_members,
                'image_url' => $community['image_url'],
                'creator_username' => $community['creator_username'],
                'display_name' => $community['display_name'],
                'tagline' => $community['tagline'],
                'links' => $community['links'],
                'total_posts' => $total_posts
            );
        }
    }

    $conn->close();

    return $communities;
}

if (isset($_GET['username']) && !empty($_GET['username'])) {
    $username = $_GET['username'];
    $communityData = fetchCommunities($username);
} else {
    $communityData = fetchCommunities();
}

echo json_encode($communityData);
?>