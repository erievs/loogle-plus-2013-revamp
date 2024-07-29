<?php

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

function getPostsAndComments($username = null) {
    include("../important/db.php");

    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

    if ($conn->connect_error) {
        die(json_encode(array('status' => 'error', 'message' => "Connection failed: " . $conn->connect_error)));
    }

    $postsQuery = "SELECT * FROM posts";
    
    if ($username !== null) {
        $postsQuery .= " WHERE username = '" . $conn->real_escape_string($username) . "'";
    }
    
    $postsQuery .= " ORDER BY created_at DESC";

    $postsResult = $conn->query($postsQuery);

    $data = array();

    if ($postsResult->num_rows > 0) {
        while ($post = $postsResult->fetch_assoc()) {
            $postId = $post['id'];
            $commentsQuery = "SELECT * FROM comments WHERE post_id = $postId";
            $commentsResult = $conn->query($commentsQuery);

            $comments = array();

            if ($commentsResult->num_rows > 0) {
                while ($comment = $commentsResult->fetch_assoc()) {
                    $comments[] = array(
                        'username' => $comment['username'],
                        'comment_content' => $comment['comment_content']
                    );
                }
            }

            $post_url = isset($post['post_url']) ? $post['post_url'] : null;
            $video_url = isset($post['video_url']) ? $post['video_url'] : null;
            $plus_one = isset($post['plus_one']) ? (int)$post['plus_one'] : 0;
            $plus_one_usernames = isset($post['plus_one_usernames']) ? $post['plus_one_usernames'] : '';

            $image_url = !empty($post['image_url']) ? $siteurl . "/" . $post['image_url'] : null;

            $data[] = array(
                'post' => array(
                    'id' => $post['id'],
                    'username' => $post['username'],
                    'content' => $post['content'],
                    'image_url' => $image_url,
                    'post_link' => $post['post_link'],
                    'post_link_url' => $post_url,
                    'post_url' => $video_url,
                    'created_at' => $post['created_at'],
                    'plus_one' => $plus_one,
                    'plus_one_usernames' => $plus_one_usernames
                ),
                'comments' => $comments
            );
        }
    }

    $conn->close();
    
    return json_encode($data);
}

$username = isset($_GET['username']) ? $_GET['username'] : null;
$data = getPostsAndComments($username);

echo $data;
?>
