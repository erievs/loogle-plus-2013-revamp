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
$recipient = $_POST['recipient'] ?? '';

if (!empty($sender) && !empty($content) && !empty($recipient)) {
    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt1 = $conn->prepare("INSERT INTO posts (username, content, visibility) VALUES (?, ?, 'u')");
    $stmt1->bind_param("ss", $sender, $content);
    $stmt1->execute();
    $post_id = $stmt1->insert_id;
    $stmt1->close();

    if ($post_id) {
        $stmt2 = $conn->prepare("SELECT username FROM user WHERE username = ?");
        $stmt2->bind_param("s", $recipient);
        $stmt2->execute();
        $stmt2->store_result();

        if ($stmt2->num_rows > 0) {
            $stmt2->close();

            $stmt3 = $conn->prepare("INSERT INTO notifications (sender, recipient, content, post_id) VALUES (?, ?, ?, ?)");
            $stmt3->bind_param("sssi", $sender, $recipient, $content, $post_id);
            $stmt3->execute();
            $stmt3->close();

            echo "Notification sent to $recipient and post created successfully.";
        } else {
            $stmt2->close();
            echo "Recipient not found.";
        }
    } else {
        echo "Failed to create post.";
    }

    $conn->close();
} else {
    echo "Sender, content, and recipient are required.";
}
?>
