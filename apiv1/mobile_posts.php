<?php

header("Content-Type: text/plain");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

function mobileFetchPosts() {

    include("../important/db.php");

    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $query = "SELECT id, username AS title, content AS body FROM posts ORDER BY created_at DESC";
    $result = $conn->query($query);

    $posts = array();

    if ($result->num_rows > 0) {
        while ($post = $result->fetch_assoc()) {
            $posts[] = $post;
        }
    }

    $conn->close();

    return $posts;
}

$postsData = mobileFetchPosts();

foreach ($postsData as $post) {
    echo "ID: " . $post['id'] . "\n";
    echo "Title: " . $post['title'] . "\n";
    echo "Body: " . $post['body'] . "\n";
    echo "\n"; // Separate each post with a blank line
}
?>

