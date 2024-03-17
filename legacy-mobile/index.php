<?php
session_start();
$loggedInUsername = isset($_SESSION['username']) ? $_SESSION['username'] : null;
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css">
    <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
    <title>Loogle+ Mobile</title>
</head>
<body>

<div data-role="page" id="posts-page">
    <div data-role="header">
        <h1>Loogle+ Mobile</h1>
       <?php if ($loggedInUsername) { ?>
        Username: <?php echo $loggedInUsername; ?>
        <?php } ?>
    </div>

    <div data-role="content">
        <ul data-role="listview" id="post-list">

        </ul>
    </div>

    <div data-role="footer">
        <div data-role="navbar">
            <ul>
                <li><a href="#" id="prev-page" data-icon="arrow-l">Previous</a></li>
                <li><a href="#" id="next-page" data-icon="arrow-r">Next</a></li>
            </ul>
        </div>
        <div id="page-numbers" data-role="controlgroup" data-type="horizontal">
            
        </div>
        <style>
        a{text-align: center;}
        </style>
        <?php if (!$loggedInUsername) { ?>
        <a href="./login.php">Login</a>
        <?php } ?>
        <?php if ($loggedInUsername) { ?>
        <h4><strong><a href="./post.php">Write A Post</a></strong></h4>
        <?php } ?>
        <h4>Powered by jQuery Mobile</h4>
    </div>
</div>

<script>
var postsData = []; 
var postsPerPage = 12; 
var currentPage = 1; 

$(document).on("pagecreate", "#posts-page", function () {
    var $postList = $("#post-list");
    var $pageNumbers = $("#page-numbers");

    function updatePostList() {
        $postList.empty();

        var startIndex = (currentPage - 1) * postsPerPage;
        var endIndex = startIndex + postsPerPage;

        for (var i = startIndex; i < endIndex && i < postsData.length; i++) {
            var post = postsData[i];
            var listItem = '<li>';
            listItem += '<h2>' + post.username + '</h2>';
            listItem += '<p>' + post.content + '</p>';
            if (post.image_url) {
                listItem += '<img src="' + post.image_url + '" style="width: 33%;" alt="Post Image">';
            }
            listItem += '<p>' + post.created_at + '</p>';
            listItem += '</li>';
            $postList.append(listItem);
        }

        $postList.listview("refresh");

        var numPages = Math.ceil(postsData.length / postsPerPage);
        $pageNumbers.empty();
        for (var i = 1; i <= numPages; i++) {
            var pageLink = '<a href="#" class="page-link" data-page="' + i + '">' + i + '</a>';
            if (i === currentPage) {
                pageLink = '<strong>' + i + '</strong>';
            }
            $pageNumbers.append(pageLink);
        }
    }

    $("#next-page").on("click", function () {
        if (currentPage < Math.ceil(postsData.length / postsPerPage)) {
            currentPage++;
            updatePostList();
        }
    });

    $("#prev-page").on("click", function () {
        if (currentPage > 1) {
            currentPage--;
            updatePostList();
        }
    });

    $(document).on("click", ".page-link", function () {
        var selectedPage = parseInt($(this).data("page"));
        if (!isNaN(selectedPage)) {
            currentPage = selectedPage;
            updatePostList();
        }
    });

    $.ajax({
        url: "/apiv1/fetch_posts_api.php",
        method: "GET",
        dataType: "json",
        success: function (data) {

            postsData = data;

            updatePostList();
        },
        error: function () {
            alert("Error fetching posts. Please check your connection.");
        }
    });
});
</script>

</body>
</html>