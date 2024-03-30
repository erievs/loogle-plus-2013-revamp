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
        $postContent = $argv[1];
    } else {
        $username = $_POST['username']; 
        $postContent = $_POST['postContent'];
    }

    $expectedReferer = "http://localhost:8080/"; 
    $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';

    if (parse_url($referer, PHP_URL_HOST) !== parse_url($expectedReferer, PHP_URL_HOST)) {
        $response['status'] = 'error';
        $response['message'] = 'Invalid Referer. Requests must come from the same URL.';
        echo json_encode($response);
        exit;
    }

    // Function to extract mentioned usernames from post content
    function extractMentions($content) {
        preg_match_all('/\+([a-zA-Z0-9_]+)/', $content, $matches);
        return $matches[1];
    }

    $mentions = extractMentions($postContent);

    $rateLimitFile = sys_get_temp_dir() . '/' . 'ratelimit.txt'; 
    if (!isRateLimited($rateLimitFile, $rateLimit)) {
        $imageURL = '';

        if ($_FILES["postImage"]["error"] === 0) {
            $targetDir = "../assets/images/";
            $randomFilename = uniqid() . "_" . basename($_FILES["postImage"]["name"]);
            $targetFile = $targetDir . $randomFilename;
            if (move_uploaded_file($_FILES["postImage"]["tmp_name"], $targetFile)) {
                $imageURL = $targetFile;
            }
        }

        $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

        if ($conn->connect_error) {
            $response['status'] = 'error';
            $response['message'] = "Connection failed: " . $conn->connect_error;
        } else {
            $query = "INSERT INTO posts (username, content, image_url, created_at) VALUES (?, ?, ?, NOW())";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("sss", $username, $postContent, $imageURL);
            $stmt->execute();

            // Insert mentions into the database
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
