<?php
session_start();

if (isset($_SESSION['username']) && isset($_POST['username'])) {

    include("../important/db.php");
    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    function fetchCommunityPost($community_id, $post_id) {
        global $conn;
        $sql = "SELECT * FROM communities_posts WHERE id = ? AND community_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $post_id, $community_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $post = $result->fetch_assoc();
            return $post;
        } else {
            return null; 
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['fetch_plus_one']) && isset($_GET['id']) && isset($_GET['community_id'])) {
        $postId = $_GET['id'];
        $communityId = $_GET['community_id'];
        $post = fetchCommunityPost($communityId, $postId);

        if ($post !== null) {
            $responseText = "+(" . $post['plus_one'] . ")";
            echo json_encode(array("plus_one_text" => $responseText));
        } else {
            http_response_code(404);
            echo json_encode(array("error" => "Post not found"));
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_plus_one']) && isset($_POST['id']) && isset($_POST['community_id'])) {
        $postId = $_POST['id'];
        $communityId = $_POST['community_id'];
        $username = $_POST['username'];

        $post = fetchCommunityPost($communityId, $postId);

        if ($post !== null) {
            // Ensure plus_one is set to 1 if it's null
            if ($post['plus_one'] === null) {
                $sqlUpdate = "UPDATE communities_posts SET plus_one = 1 WHERE id = $postId AND community_id = $communityId";
                if ($conn->query($sqlUpdate) !== TRUE) {
                    http_response_code(500);
                    echo json_encode(array("error" => "Error setting plus one count: " . $conn->error));
                    exit();
                }
            }

            $plusOneUsernames = json_decode($post['plus_one_usernames'], true);

            if ($plusOneUsernames === null) {
                $plusOneUsernames = [];
            }

            $index = array_search($username, $plusOneUsernames);
            if ($index !== false) {
                unset($plusOneUsernames[$index]);
                $sqlUpdate = "UPDATE communities_posts SET plus_one = plus_one - 1, plus_one_usernames = '" . json_encode($plusOneUsernames) . "' WHERE id = $postId AND community_id = $communityId";
            } else {
                $plusOneUsernames[] = $username;
                $sqlUpdate = "UPDATE communities_posts SET plus_one = plus_one, plus_one_usernames = '" . json_encode($plusOneUsernames) . "' WHERE id = $postId AND community_id = $communityId";
            }

            if ($conn->query($sqlUpdate) === TRUE) {
                echo json_encode(array("message" => "Plus one updated successfully"));
            } else {
                http_response_code(500);
                echo json_encode(array("error" => "Error updating plus one count: " . $conn->error));
            }
        } else {
            http_response_code(404);
            echo json_encode(array("error" => "Post not found"));
        }
    }

    $conn->close();
} else {
    http_response_code(403);
    echo json_encode(array("error" => "Unauthorized access"));
}
?>
