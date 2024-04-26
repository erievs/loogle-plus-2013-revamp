<?php

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

function fetchCommunityPosts($community_id) {
    include("../important/db.php");
    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $query = "SELECT * FROM communities_posts WHERE community_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $community_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $posts = array();

    if ($result->num_rows > 0) {
        while ($post = $result->fetch_assoc()) {
            if (!empty($post['image_url'])) {
                $image_url = str_replace('..', '', $siteurl) . str_replace('..', '', $post['image_url']);
            } else {
                $image_url = null;
            }

            if (!empty($post['post_link_url'])) {
                $post_url = $post['post_link_url'];
            } else {
                $post_url = null;
            }

            if (!empty($post['post_url'])) {
                $video_url = $post['post_url'];
            } else {
                $video_url = null;
            }

            $plus_one = $post['plus_one'] + 1;

            $posts[] = array(
                'id' => $post['id'],
                'username' => $post['username'],
                'content' => htmlspecialchars($post['content']),
                'image_url' => $image_url,
                'post_link' => $post['post_link'],
                'post_link_url' => $post_url, 
                'post_url' => $video_url, 
                'created_at' => $post['created_at'],
                'plus_one' =>  $plus_one,
                'plus_one_usernames' =>  $post['plus_one_usernames']
            );
        }
    }

    $stmt->close();
    $conn->close();

    return $posts;
}

if (isset($_GET['community_id'])) {
    $community_id = $_GET['community_id'];
    $postsData = fetchCommunityPosts($community_id);
} else {
    $postsData = array(); // If community_id is not provided, return an empty array
}

echo json_encode($postsData);
?>
