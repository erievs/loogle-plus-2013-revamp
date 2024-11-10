<?php

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

function getPostsFromDatabase($username = null) {
    include("../important/db.php");
    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $query = "SELECT * FROM posts";
    if ($username !== null) {
        $query .= " WHERE username = '$username'";
    }
    $query .= " ORDER BY (plus_one > 0 AND (content LIKE '%cfl%' OR content LIKE '%cfls%')) DESC, plus_one DESC, created_at DESC"; // Prioritize posts containing 'cfl' or 'cfls'

    $query .= " LIMIT 25"; // Limit the result to 25 posts

    $result = $conn->query($query);
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

    $conn->close();

    return $posts;
}

if (isset($_GET['username'])) {
    $username = $_GET['username'];
    $postsData = getPostsFromDatabase($username);
} else {
    $postsData = getPostsFromDatabase();
}

echo json_encode($postsData);
?>
