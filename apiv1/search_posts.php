<?php

header("Content-Type: application/json; charset=utf-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

function searchPostsInDatabase($query, $page = 1, $postsPerPage = 16) {
    include("../important/db.php");
    global $siteurl;

    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $conn->set_charset("utf8");

    $offset = ($page - 1) * $postsPerPage;

    $searchQuery = "%" . $conn->real_escape_string($query) . "%";

    $stmt = $conn->prepare(
        "SELECT * FROM posts WHERE (content LIKE ? OR username LIKE ?) AND visibility = 'v' ORDER BY created_at DESC LIMIT ?, ?"
    );
    $stmt->bind_param("ssii", $searchQuery, $searchQuery, $offset, $postsPerPage);

    $stmt->execute();
    $result = $stmt->get_result();
    $posts = array();

    while ($post = $result->fetch_assoc()) {
        $image_url = !empty($post['image_url']) ? $siteurl . str_replace('..', '', $post['image_url']) : null;
        $post_url = !empty($post['post_link_url']) ? $post['post_link_url'] : null;
        $video_url = !empty($post['post_url']) ? $post['post_url'] : null;
        $plus_one = isset($post['plus_one']) ? $post['plus_one'] + 1 : 1;

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
            'plus_one_usernames' => $post['plus_one_usernames']
        );
    }

    $stmt->close();
    $conn->close();

    if (empty($posts)) {
        $posts[] = array(
            'id' => null,
            'username' => 'System',
            'content' => 'No posts found for your search query.',
            'image_url' => null,
            'post_link' => null,
            'post_link_url' => null,
            'post_url' => null,
            'created_at' => date('Y-m-d H:i:s'),
            'plus_one' => 0,
            'plus_one_usernames' => ''
        );
    }

    return $posts;
}

$query = isset($_GET['query']) ? $_GET['query'] : ''; 
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; 
$postsPerPage = 15; 

if (!empty($query)) {
    $postsData = searchPostsInDatabase($query, $page, $postsPerPage);
} else {
    $postsData = array();
}

echo json_encode($postsData, JSON_UNESCAPED_UNICODE);
?>
