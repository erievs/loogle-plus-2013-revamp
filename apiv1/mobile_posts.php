<?php

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

function getPostsAndComments($username = null) {
    include("../important/db.php");

    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
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
                        'username' => htmlspecialchars($comment['username']),
                        'comment_content' => htmlspecialchars($comment['comment_content'])
                    );
                }
            }

            if (!empty($post['image_url'])) {
                $image_url = 'http://kspc.serv00.net/' . $post['image_url'];
            } else {
                $image_url = null;
            }

            $data[] = array(
                'post' => array(
                    'id' => $post['id'],
                    'username' => $post['username'],
                    'content' => htmlspecialchars($post['content']),
                    'image_url' => $image_url,
                    'post_link' => $post['post_link'],
                    'created_at' => $post['created_at']
                ),
                'comments' => $comments
            );
        }
    }

    $conn->close();

    return $data;
}

$username = isset($_GET['username']) ? $_GET['username'] : null;
$data = getPostsAndComments($username);

echo json_encode($data);
?>

