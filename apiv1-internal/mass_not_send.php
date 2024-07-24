<?php
include("../important/db.php");

$allowed_origin = parse_url($siteurl, PHP_URL_HOST);
$origin = isset($_SERVER['HTTP_ORIGIN']) ? parse_url($_SERVER['HTTP_ORIGIN'], PHP_URL_HOST) : '';
$referer = isset($_SERVER['HTTP_REFERER']) ? parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST) : '';

if ($origin !== $allowed_origin && $referer !== $allowed_origin) {
    http_response_code(403); 
    echo json_encode(array('error' => 'Access denied.'));
    exit();
}

$sender = $_POST['sender'] ?? '';
$content = $_POST['content'] ?? '';

if (!empty($sender) && !empty($content)) {

    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("INSERT INTO posts (username, content, visibility) VALUES (?, ?, 'u')");
    $stmt->bind_param("ss", $sender, $content);
    $stmt->execute();
    $post_id = $stmt->insert_id;
    $stmt->close();

    if ($post_id) {
        $sql = "SELECT username FROM user";
        $result = $conn->query($sql);

        if ($result) {
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $recipient = $row['username'];

                    $stmt = $conn->prepare("INSERT INTO notifications (sender, recipient, content, post_id) VALUES (?, ?, ?, ?)");
                    $stmt->bind_param("sssi", $sender, $recipient, $content, $post_id);
                    $stmt->execute();
                    $stmt->close();
                }
                echo "Notifications and post created successfully.";
            } else {
                echo "No users found.";
            }
        } else {
            echo "Error executing query: " . $conn->error;
        }
    } else {
        echo "Failed to create post.";
    }

    $conn->close();
} else {
    echo "Sender and content are required.";
}
?>
