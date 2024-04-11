<?php
session_start();
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
$isCommandLine = php_sapi_name() === 'cli';

$rateLimit = 2.5;

$response = array();

include("../important/db.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' || $isCommandLine) {
    if ($isCommandLine) {
        $username = $argv[1];
    } else {
        $username = isset($_POST['username']) ? $_POST['username'] : '';
        $postContent = isset($_POST['postContent']) ? $_POST['postContent'] : '';
        $post_link_url = isset($_POST['post_link_url']) ? $_POST['post_link_url'] : '';
        $post_link = isset($_POST['post_link']) ? $_POST['post_link'] : '';
    }

    if (empty($username)) {
        $response['status'] = 'error';
        $response['message'] = 'Invalid request. Missing parameters: username.';
        echo json_encode($response);
        exit;
    }

    if (!empty($post_link)) {
        // Convert YouTube URL to embed URL
        if (preg_match('/^(https?:\/\/)?(www\.)?(youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]+)/', $post_link, $matches)) {
            $video_id = $matches[4];
            $post_link = "http://www.youtube.com/embed/$video_id";
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Invalid YouTube URL format.';
            echo json_encode($response);
            exit;
        }
    }

    // Validate URL format for post_link_url
    if (!empty($post_link_url) && !filter_var($post_link_url, FILTER_VALIDATE_URL)) {
        $response['status'] = 'error';
        $response['message'] = 'Invalid URL format for post_link_url.';
        echo json_encode($response);
        exit;
    }

    // Check if at least one content field is provided
    if (empty($postContent) && empty($post_link) && empty($post_link_url)) {
        $response['status'] = 'error';
        $response['message'] = 'Invalid request. At least one content field (postContent, post_link, or post_link_url) must be provided.';
        echo json_encode($response);
        exit;
    }

    function extractMentions($content) {
        preg_match_all('/\+([a-zA-Z0-9_]+)/', $content, $matches);
        return $matches[1];
    }

    $mentions = extractMentions($postContent);

    $rateLimitFile = sys_get_temp_dir() . '/' . 'ratelimit.txt';
    if (!isRateLimited($rateLimitFile, $rateLimit)) {

        $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

        if ($conn->connect_error) {
            $response['status'] = 'error';
            $response['message'] = "Connection failed: " . $conn->connect_error;
        } else {
            $query = "INSERT INTO posts (username, content, post_link_url, post_link, created_at) VALUES (?, ?, ?, ?, NOW())";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ssss", $username, $postContent, $post_link_url, $post_link);
            $stmt->execute();

            $postId = $conn->insert_id;
            foreach ($mentions as $mentionedUser) {
                $mentionContent = "Has mentioned you in a post";
                $mentionSender = $username;
                $insertMentionQuery = "INSERT INTO notifications (recipient, content, created_at, read_status, sender, post_id) VALUES (?, ?, NOW(), 0, ?, ?)";
                $stmt = $conn->prepare($insertMentionQuery);
                $stmt->bind_param("sssi", $mentionedUser, $mentionContent, $mentionSender, $postId);
                $stmt->execute();
            }

            $stmt->close();
            $conn->close();

            if ($isCommandLine) {
                $response['status'] = 'success';
                $response['message'] = "Post successfully submitted via command line.";
            } else {
                $response['status'] = 'success';
                $response['message'] = 'Post successfully submitted.';
            }
        }
    } else {
        if ($isCommandLine) {
            $response['status'] = 'error';
            $response['message'] = "Error: You can only post once every $rateLimit second(s).";
        } else {
            $response['status'] = 'error';
            $response['message'] = "Error: You can only post once every $rateLimit second(s).";
        }
        echo json_encode($response);
        exit;
    }
}

if (!$isCommandLine) {
    $response['status'] = 'error';
    $response['message'] = 'Invalid request or missing parameters.';
    header('Content-Type: application/json');
    echo json_encode($response);
}

function isRateLimited($rateLimitFile, $rateLimit) {
    if (!file_exists($rateLimitFile) || (time() - filemtime($rateLimitFile)) > $rateLimit) {
        touch($rateLimitFile);
        return false;
    } else {
        return true;
    }
}
?>
