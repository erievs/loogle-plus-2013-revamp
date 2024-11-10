<?php

header("Content-Type: application/json; charset=utf-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

function getPostsFromDatabase($username = null, $page = 1, $postsPerPage = 16, $disablePagination = false) {
    include("../important/db.php");
    global $siteurl;

    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $conn->set_charset("utf8");

    if ($disablePagination) {
        $query = "SELECT * FROM posts WHERE visibility = 'v' ORDER BY created_at DESC";
        if ($username !== null) {
            $stmt = $conn->prepare("SELECT * FROM posts WHERE visibility = 'v' AND username = ? ORDER BY created_at DESC");
            $stmt->bind_param("s", $username);
        } else {
            $stmt = $conn->prepare($query);
        }
    } else {
        $offset = ($page - 1) * $postsPerPage;
        if ($username !== null) {
            $stmt = $conn->prepare("SELECT * FROM posts WHERE visibility = 'v' AND username = ? ORDER BY created_at DESC LIMIT ?, ?");
            $stmt->bind_param("sii", $username, $offset, $postsPerPage);
        } else {
            $stmt = $conn->prepare("SELECT * FROM posts WHERE visibility = 'v' ORDER BY created_at DESC LIMIT ?, ?");
            $stmt->bind_param("ii", $offset, $postsPerPage);
        }
    }

    $stmt->execute();
    $result = $stmt->get_result();
    $posts = array();

    while ($post = $result->fetch_assoc()) {
        $image_url = !empty($post['image_url']) ? $siteurl . str_replace('..', '', $post['image_url']) : null;
        $post_url = !empty($post['post_link_url']) ? $post['post_link_url'] : null;
        $video_url = !empty($post['post_url']) ? $post['post_url'] : null;
        $plus_one = isset($post['plus_one']) ? $post['plus_one'] + 1 : 1;

        $comments = getCommentsForPost($post['id']);

        $posts[] = array(
            'id' => $post['id'],
            'username' => $post['username'],
            'content' => $post['content'],
            'image_url' => $image_url,
            'post_link' => $post['post_link'],
            'post_link_url' => $post_url,
            'post_url' => $video_url,
            'created_at' => $post['created_at'],
            'plus_one' => $plus_one,
            'plus_one_usernames' => $post['plus_one_usernames'],
            'comments' => $comments 
        );
    }

    $stmt->close();
    $conn->close();

    return $posts;
}

function getCommentsForPost($post_id) {
    include("../important/db.php");

    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
    $comments = array();

    if ($conn->connect_error) {
        return $comments; 
    }

    $conn->set_charset("utf8");

    $sql = "SELECT * FROM comments WHERE post_id = ? ORDER BY created_at ASC"; 

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $post_id);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($comment = $result->fetch_assoc()) {

            $profile_image_url = $siteurl . "/apiv1/fetch_pfp_api.php?username=" . urlencode($comment['username']);

            $comments[] = array(
                'username' => $comment['username'],
                'comment_content' => $comment['comment_content'],
                'comment_time' => $comment['created_at'],
                'profile_image_url' => $profile_image_url 
            );
        }

        $stmt->close();
    }

    $conn->close();

    return $comments;
}

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; 
$postsPerPage = 15; 

$disablePagination = isset($_GET['disable_pagination']) && $_GET['disable_pagination'] === 'true';

if (isset($_GET['username'])) {
    $username = $_GET['username'];
    $postsData = getPostsFromDatabase($username, $page, $postsPerPage, $disablePagination);
} else {
    $postsData = getPostsFromDatabase(null, $page, $postsPerPage, $disablePagination);
}

echo json_encode($postsData, JSON_UNESCAPED_UNICODE);
?>