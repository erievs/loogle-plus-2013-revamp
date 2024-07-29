
<?php
session_start();

include("important/db.php");

if (!isset($_SESSION["username"])) {
  header("Location: ../user/login.php");
  exit();
}

$username = $_SESSION["username"];


$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$stmt = $conn->prepare("SELECT username FROM moderators WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->store_result();

$isMod = ($stmt->num_rows > 0);

$stmt->close();
$conn->close();

$icon = "home";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loogle+</title>

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="http://egkoppel.github.io/product-sans/google-fonts.css"> 
    <link rel="stylesheet" href="assets/css/materialize.min.css">
    
    <link rel="icon" href="assets/images/favicon.ico" />

    <link rel="stylesheet" href="assets/css/2015index.css">
    <link rel="stylesheet" href="assets/css/2015uni.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>
<body>

    <?php include("inc/navbar.php"); ?>


    <div id="posts-container"></div>

<script>
    $(document).ready(function() {

        function getRelativeTime(date) {
                    const now = new Date();
                    const diff = now - new Date(date);
                    const seconds = Math.floor(diff / 1000);
                    const minutes = Math.floor(seconds / 60);
                    const hours = Math.floor(minutes / 60);
                    const days = Math.floor(hours / 24);
                    const months = Math.floor(days / 30);
                    const years = Math.floor(months / 12);

                    if (years > 0) return years + 'y';
                    if (months > 0) return months + 'm';
                    if (days > 0) return days + 'd';
                    if (hours > 0) return hours + 'h';
                    if (minutes > 0) return minutes + 'm';
                    return seconds + 's';
        }

        $.ajax({
            url: '<?php echo $siteurl; ?>/apiv1/fetch_posts_api.php', 
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                var postsContainer = $('#posts-container');
                
                data.forEach(function(post) {

                    var relativeTime = getRelativeTime(post.created_at);

                    var postTemplate = `
                        <div class="post">
                            <div class="post-header">
                                <img id="thekhive" src="<?php echo $siteurl; ?>/apiv1/fetch_pfp_api.php?name=${post.username}" class="profile-picture">
                                <span id="post-username">${post.username}</span>
                                <span class="created-at">${relativeTime}</span>
                            </div>
                            <p>${post.content}</p>
                            ${post.image_url ? `<img id="post-image" src="${post.image_url}" alt="Image">` : ''}
                            ${post.post_link ? `<a href="${post.post_link_url}" target="_blank">${post.post_link}</a>` : ''}
                            ${post.post_url ? `<a href="${post.post_url}" target="_blank">Watch Video</a>` : ''}                          
                        </div>`;
                    postsContainer.append(postTemplate);
                });
            },
            error: function() {
                $('#posts-container').html('<p>Failed to load posts.</p>');
            }
        });
    });
</script>

</body>
</html>
