<?php

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

function getPostById($postId) {
    include("../important/db.php");

    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $postId = $conn->real_escape_string($postId); 

    $query = "SELECT * FROM posts WHERE id = $postId";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $post = $result->fetch_assoc();

        if (!empty($post['image_url'])) {
            $image_url = str_replace('..', '', $siteurl) . str_replace('..', '', $post['image_url']);
        } else {
            $image_url = 'null';
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

        $postData = array(
            'id' => $post['id'],
            'username' => $post['username'],
            'content' => htmlspecialchars($post['content'], ENT_NOQUOTES), 
            'image_url' => $image_url,
            'post_link_url' => $post_url, 
            'post_link' => $post['post_link'],
            'created_at' => $post['created_at'],
            'plus_one' =>  $plus_one,
            'plus_one_usernames' =>  $post['plus_one_usernames']
        );

        $conn->close();

        return $postData;
    } else {
        $conn->close();
        return null; 
    }
}

if (isset($_GET['id'])) {
    $postId = $_GET['id'];
    $postData = getPostById($postId);

    if ($postData) {
        echo json_encode($postData);
    } else {
        http_response_code(404);
        echo json_encode(array('message' => 'Post not found'));
    }
} else {
    http_response_code(400); 
    echo json_encode(array('message' => 'Post ID is required'));
}
?>