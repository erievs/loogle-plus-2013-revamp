<?php

ob_start(); // Start output buffering

header("Content-Type: application/xml");
header("Access-Control-Allow-Origin: *");

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
    $query .= " ORDER BY created_at DESC";

    $result = $conn->query($query);
    $posts = array();

    if ($result->num_rows > 0) {
        while ($post = $result->fetch_assoc()) {
            $item = '<item>';
            $item .= '<title>' . htmlspecialchars($post['content']) . '</title>';
            $item .= '<description><![CDATA[' . htmlspecialchars($post['content']) . ']]></description>';
            $item .= '<link>' . htmlspecialchars($siteurl . '/view_post.php?id=' . $post['id']) . '</link>'; 
            $item .= '<pubDate>' . date('r', strtotime($post['created_at'])) . '</pubDate>';
            $item .= '</item>';
            $posts[] = $item;
        }
    }

    $conn->close();

    return $posts;
}

$postsData = getPostsFromDatabase();

$imageUrl = isset($_GET['regan']) ? '../assets/images/regan.png' : '../assets/images/loogle.webp';

$rssFeed = '<?xml version="1.0" encoding="UTF-8"?>';
$rssFeed .= '<rss version="2.0">';
$rssFeed .= '<channel>';
$rssFeed .= '<title>Loogle+</title>';
$rssFeed .= '<link>' . htmlspecialchars($siteurl) . '</link>'; 
$rssFeed .= '<description>Loogle+ a 2013 Google+ recreation.</description>';
$rssFeed .= '<language>en-us</language>';
$rssFeed .= '<image>';
$rssFeed .= '<url>' . htmlspecialchars($siteurl . $imageUrl) . '</url>'; 
$rssFeed .= '<title>LoogleCon</title>'; 
$rssFeed .= '<link>' . htmlspecialchars($siteurl) . '</link>';
$rssFeed .= '</image>';

foreach ($postsData as $post) {
    $rssFeed .= $post;
}

$rssFeed .= '</channel>';
$rssFeed .= '</rss>';

ob_end_clean();

echo $rssFeed;
?>
