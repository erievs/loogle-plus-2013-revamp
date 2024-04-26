<?php
function getCommentsForCommunityPost() {
    include("../important/db.php");

    if (isset($_GET['id']) && isset($_GET['community_id'])) {
        $post_id = $_GET['id'];
        $community_id = $_GET['community_id'];

        $conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

        $response = array();

        if (!$conn) {
            $response['status'] = 'error';
            $response['message'] = "Connection failed: " . mysqli_connect_error();
        } else {
            // Query to retrieve comments for a specific post within a community
            $comments_sql = "SELECT cc.*, p.plus_one 
                             FROM community_comments cc 
                             LEFT JOIN communities_posts p ON cc.post_id = p.id 
                             WHERE cc.post_id = ? AND p.community_id = ?";
            if ($comments_stmt = mysqli_prepare($conn, $comments_sql)) {
                mysqli_stmt_bind_param($comments_stmt, "ii", $post_id, $community_id);
                mysqli_stmt_execute($comments_stmt);
                $comments_result = mysqli_stmt_get_result($comments_stmt);

                if (mysqli_num_rows($comments_result) > 0) {
                    $comments = array();

                    while ($comment = mysqli_fetch_assoc($comments_result)) {
                        $comments[] = array(
                            'username' => htmlspecialchars($comment['username']),
                            'comment_content' => htmlspecialchars($comment['comment_content']),
                            'comment_time' => htmlspecialchars($comment['created_at']),
                            'plus_ones' => $comment['plus_one'] // Add plus_ones to each comment
                        );
                    }

                    $response['status'] = 'success';
                    $response['comments'] = $comments;
                } else {
                    $response['status'] = 'error';
                    $response['message'] = 'No comments found for the given post ID within the community';
                }

                mysqli_stmt_close($comments_stmt);
            } else {
                $response['status'] = 'error';
                $response['message'] = 'Failed to retrieve comments: ' . mysqli_error($conn);
            }

            mysqli_close($conn);
        }

        header("Content-Type: application/json");
        echo json_encode($response);
    } else {
        echo "Please provide valid 'id' and 'community_id' parameters in the URL.";
    }
}

getCommentsForCommunityPost();



?>
