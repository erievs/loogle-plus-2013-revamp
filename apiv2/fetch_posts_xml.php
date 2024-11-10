<?php

header("Content-Type: application/atom+xml; charset=utf-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

function getPostsFromDatabase($username = null, $disablePagination = false) {
    include("../important/db.php");
    global $siteurl; 

    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $conn->set_charset("utf8");

    $query = "SELECT * FROM posts WHERE visibility = 'v' ORDER BY created_at DESC";
    if ($username !== null) {
        $stmt = $conn->prepare("SELECT * FROM posts WHERE visibility = 'v' AND username = ? ORDER BY created_at DESC");
        $stmt->bind_param("s", $username);
    } else {
        $stmt = $conn->prepare($query);
    }

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

    return $posts;
}

if (isset($_GET['username'])) {
    $username = $_GET['username'];
    $postsData = getPostsFromDatabase($username);
} else {
    $postsData = getPostsFromDatabase(null);
}

$feedTitle = "Loogle"; 
$feedLink = $siteurl . "/posts"; 
$feedUpdated = date(DATE_ATOM);

echo '<?xml version="1.0" encoding="UTF-8"?>';
echo '<feed xmlns="http://www.w3.org/2005/Atom">';
echo "<title>$feedTitle</title>";
echo "<link href=\"$feedLink\"/>";
echo "<updated>$feedUpdated</updated>";
echo "<id>$feedLink</id>";

foreach ($postsData as $post) {
    $postId = $post['id'];
    $postTitle = htmlspecialchars($post['content']); 
    $postUrl = htmlspecialchars($post['post_link_url'] ?: $post['post_url']); 
    $postUpdated = date(DATE_ATOM, strtotime($post['created_at'])); 

    echo "<entry>";
    echo "<title>$postTitle</title>";
    echo "<link href=\"$postUrl\"/>";
    echo "<id>$siteurl/post/$postId</id>";
    echo "<updated>$postUpdated</updated>";
    echo "<summary>" . htmlspecialchars($post['content']) . "</summary>"; 
    echo "</entry>";
}

echo '</feed>';
?>