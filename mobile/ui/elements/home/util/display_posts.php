<?php 
function displayPosts($posts) {
    $loggedInUsername = $_SESSION['username'];

    foreach ($posts as $post) {
        $postUsername = $post['username'];
        $postContent = htmlspecialchars($post['content']);
        $postImageURL = $post['image_url'];
        $imageLink = $post['image_link'];
        $postLink = $post['post_link'];
        $timestamp = strtotime($post['created_at']); 

        $currentTime = time();
        $timeDifference = $currentTime - $timestamp;

        if ($timeDifference < 60) {
            $formattedTimestamp = $timeDifference == 1 ? '1s' : $timeDifference . 's'; 
        } elseif ($timeDifference < 3600) {
            $minutes = floor($timeDifference / 60);
            $formattedTimestamp = $minutes == 1 ? '1m' : $minutes . 'm'; 
        } elseif ($timeDifference < 86400) {
            $hours = floor($timeDifference / 3600);
            $formattedTimestamp = $hours == 1 ? '1h' : $hours . 'h'; 
        } else {
            $days = floor($timeDifference / 86400);
            $formattedTimestamp = $days == 1 ? '1d' : $days . 'd'; 
        }

        echo '<div class="post database-post">'; 
        echo '<p>';

        if ($postUsername === $loggedInUsername) {
            echo '<span class="timestamp-right" style="font-family: "Product Sans", sans-serif; color: #B0B0B0;">' . $formattedTimestamp . '</span>';
            echo '<span class="username"><a href="view_post.php?post_id=' . $post['id'] . '">' . $postUsername . '</a></span>';
            echo '<a class="more_vert"><i class="material-icons">more_vert</i></a>';
            echo '<br>';
        } else {
            echo '<span class="timestamp-right" style="font-family: "Product Sans", sans-serif; color: #B0B0B0;">' . $formattedTimestamp . '</span>';
            echo '<span class="username"><a href="view_post.php?post_id=' . $post['id'] . '">' . $postUsername . '</a></span>';
            echo '<br>';
        }

        echo '<p>' . $postContent . '</p>';

        echo '</p>';

        echo '<br>';

        echo '<br>';

        if (!empty($postImageURL)) {
            echo '<img src="../' . $postImageURL . '" alt="Post Image">';
        }

        if (!empty($imageLink)) {
            echo '<a href="' . $imageLink . '">Link to Image</a>';
        }

        if (!empty($postLink)) {
            echo '<a href="' . $postLink . '">Link to Post</a>';
        }

        echo '</div>';
    }
}
?>