<?php
function getCommentsForPost() {
    include("../important/db.php");
    if (isset($_GET['id'])) {
        $post_id = $_GET['id'];

        $conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

        $response = array();

        if (!$conn) {
            $response['status'] = 'error';
            $response['message'] = "Connection failed: " . mysqli_connect_error();
        } else {
            $sql = "SELECT * FROM community_comments WHERE post_id = ?";

            if ($stmt = mysqli_prepare($conn, $sql)) {
                mysqli_stmt_bind_param($stmt, "i", $post_id);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);

                if (mysqli_num_rows($result) > 0) {
                    $comments = array();

                    while ($comment = mysqli_fetch_assoc($result)) {
                        $comments[] = array(
                            'username' => htmlspecialchars($comment['username']),
                            'comment_content' => htmlspecialchars($comment['comment_content']),
                            'comment_time' => htmlspecialchars($comment['created_at'])
                        );
                    }

                    $response['status'] = 'success';
                    $response['comments'] = $comments;
                } else {
                    $response['status'] = 'error';
                    $response['message'] = 'No comments found for the given post ID';
                }

                mysqli_stmt_close($stmt);
            }

            mysqli_close($conn);
        }

        header("Content-Type: application/json");
        echo json_encode($response);
    } else {

        echo "Please provide a valid 'id' parameter in the URL.";
    }
}

getCommentsForPost();
?>
