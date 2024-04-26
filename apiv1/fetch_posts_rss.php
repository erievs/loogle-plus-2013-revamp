<?php

ob_start(); 

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

$outputType = isset($_GET['output']) ? $_GET['output'] : '';

if ($outputType === 'json') {
    header('Content-Type: application/json');
} else {
    header('Content-Type: application/rss+xml');
}

$output = '';

if ($outputType === 'json') {

    $output = json_encode($postsData);
} else {

    $rssVersion = isset($_GET['rss']) && $_GET['rss'] === 'legacy' ? '1.0' : '2.0';

    $output = '<?xml version="1.0" encoding="UTF-8"?>';
    $output .= '<rss version="' . $rssVersion . '">';
    $output .= '<channel>';
    $output .= '<title>Loogle+</title>';
    $output .= '<link>' . htmlspecialchars($siteurl) . '</link>'; 
    $output .= '<description>Loogle+ a 2013 Google+ recreation.</description>';
    $output .= '<language>en-us</language>';
    $output .= '<image>';
    $output .= '<url>' . htmlspecialchars($siteurl . $imageUrl) . '</url>'; 
    $output .= '<title>LoogleCon</title>'; 
    $output .= '<link>' . htmlspecialchars($siteurl) . '</link>';
    $output .= '</image>';

    foreach ($postsData as $post) {

        $output .= '<item>';
        $output .= '<title>' . htmlspecialchars($post['title']) . '</title>';
        $output .= '<link>' . htmlspecialchars($post['link']) . '</link>';
        $output .= '<description>' . htmlspecialchars($post['description']) . '</description>';

        if ($rssVersion === '2.0') {
            $output .= '<image>';
            $output .= '<url>' . htmlspecialchars($siteurl . $post['image']) . '</url>';
            $output .= '</image>';
        }

        $output .= '</item>';
    }

    $output .= '</channel>';
    $output .= '</rss>';
}

echo $output;
?>

