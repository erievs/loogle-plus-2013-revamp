<?php
$id = $_GET['id'];
?>

<?php
session_start();
if (!isset($_SESSION["username"])) {
    echo '<script>window.location.href = "../user/login.php";</script>';
    exit();
}

include("important/db.php");

?>

    
        <script type="text/javascript">
        var idFromPHP = <?php echo json_encode($id); ?>;
        console.log(idFromPHP);
    </script>

<link rel="icon" 
      type="image/png" 
      href="assets/icons/fav.png" />

      <title>Loogle+ View Post</title>

    <html lang="en">

        <head>
            <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1">
                    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
                    <link rel="stylesheet" href="assets/css/post1.css">
                    <link rel="stylesheet" href="assets/css/2013isamess.css">
					<link rel="stylesheet" href="assets/css/test.css">
                    <link rel="stylesheet" href="assets/css/post2.css">
                    <link rel="stylesheet" href="assets/css/2013notes.css">
                    <link rel="icon" 
      type="image/png" 
      href="../assets/important-images/fav.png" />
      <style>
        @media (max-width: 1280px) {
    .container {
       
        scale: 0.85; 
        margin-left: 6%; 
    }
}

@media (min-width: 721px){
.container {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
  align-items: flex-start;
  padding: 10px;
  margin-left: 20%;
}
}

.comment-input-container {
    background: #fff;
}

      </style>


</head>

<link rel="icon" 
      type="image/png" 
      href="/assets/icons/fav.png" />

                    <body>
					
<?php require_once("inc/topstuffs.php")?>

                <div class="container">
                    <div class="user-card">
                        <div class="card-info">
                        <div class="user-pfp">
						
						</div>
                        <br>
                        <div class="username-big"></div>
                        </div>
                    </div>
                    <div class="post">


                    <div class="posto-pfp-con">
                        <div class="post-pfp"></div>
                        <div class="post-info">
                            <div class="post-username"></div>
                            <div class="post-metadata">N/A</div>
                        </div>
                     </div>

                        <div class="post-content"><p></p></div>
                        <img class="post-image" src="">


                    <div class="comment-main">
                    
                    </div>

                    
                    </div>

        
                    </div>
                </div>
            </div>
            <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

            <script>


                $(document).ready(function() {



                    var id = <?php echo json_encode($id); ?>;

                    $.ajax({
                        url: '<?php echo $siteurl; ?>/apiv1/fetch_single_post.php?id=' + id,
                        type: 'GET',
                        dataType: 'json',
                        success: function (userData) {

                            const usernameElement = $(".username-big");
                            usernameElement.text(userData.username);

                            

                            const postMetadataElement = $(".post-metadata");
                            postMetadataElement.text("Placeholder - " + getRelativeTime(userData.created_at));
                        },
                        error: function () {
                            console.log('Error fetching user data.');
                        }
                    });
        });


        

                $(document).ready(function() {
 


                    var id = <?php echo json_encode($id); ?>;

                    $.ajax({
                        url: '<?php echo $siteurl; ?>/apiv1/fetch_single_post.php?id=' + id,

                        type: 'GET',
                        dataType: 'json',
                        success: function (postData) {

                            const usernameElement = $(".username, .post-username");
                            usernameElement.text(postData.username);

                            const userPfpElement = $(".user-pfp");
                            userPfpElement.css('background-image', `url(${assets / icons / pfp.png})`);
                            const postPfpElement = $(".post-pfp");
                            postPfpElement.css('background-image', `url(${assets / icons / pfp.png})`);

                            const postMetadataElement = $(".post-metadata");
                            postMetadataElement.text("Placeholder - " + getRelativeTime(postData.created_at));

                            const postContentElement = $(".post-content");
                            postContentElement.text(postData.content);

                        },
                        error: function () {
                            console.log('Error fetching user and post data.');
                        }
                    });
        });

                function getFormattedTime(createdAt) {

    const postDate = new Date(createdAt);
                const currentDate = new Date();

                const timeDifference = currentDate - postDate;

                const daysDifference = Math.floor(timeDifference / (1000 * 60 * 60 * 24));
                const monthsDifference = (currentDate.getFullYear() - postDate.getFullYear()) * 12 + (currentDate.getMonth() - postDate.getMonth());

                if (daysDifference === 0) {
        const hours = postDate.getHours();
                const minutes = postDate.getMinutes();
        const amOrPm = hours >= 12 ? 'pm' : 'am';
        let formattedHours = hours > 12 ? hours - 12 : hours;
                if (formattedHours === 0) {
                    formattedHours = 12;
        }
                const formattedMinutes = minutes < 10 ? `0${minutes}` : minutes;
                return `Today ${formattedHours}:${formattedMinutes}${amOrPm}`;
    } else if (daysDifference === 1) {
        return 'Yesterday';
    } else if (monthsDifference < 1) {
        return `${daysDifference} Days Ago`;
    } else {
        return `${monthsDifference} Months Ago`;
    }
}

                $(document).ready(function() {


                    var id = <?php echo json_encode($id); ?>;

                    $.ajax({
                        url: '<?php echo $siteurl; ?>/apiv1/fetch_single_post.php?id=' + id,
                        type: 'GET',
                        dataType: 'json',
                        success: function (postData) {

                            console.log(postData);

                            const usernameElement = $(".username, .post-username");
                            usernameElement.text(postData.username);

                            if (postData.image_url) {
                                const postImageElement = $(".post-image");
                                postImageElement.attr('src', postData.image_url);
                                postImageElement.show();
                            }
                        },
                        error: function () {
                            console.log('Error fetching user and post data.');
                        }
                    });
        });

                $(document).ready(function () {



                    var id = <?php echo json_encode($id); ?>;

                    $.ajax({
                        url: '<?php echo $siteurl; ?>/apiv1/fetch_single_post.php?id=' + id,
                        type: 'GET',
                        dataType: 'json',
                        success: function (postData) {

                            console.log(postData);

                            const usernameElement = $(".username, .post-username");
                            usernameElement.text(postData.username);

                            if (postData.image_url) {
                                const postImageElement = $(".post-image");
                                postImageElement.attr('src', postData.image_url);
                                postImageElement.show();
                            }

                            if (postData.content) {
            const postContentDiv = $(".post-content");
            const pElement = postContentDiv.find('p'); 
            pElement.text(postData.content); 
            postContentDiv.show();
        }

                            const postMetadataElement = $(".post-metadata");
                            postMetadataElement.text("Placeholder - " + getFormattedTime(postData.created_at));
                        },
                        error: function () {
                            console.log('Error fetching user and post data.');
                        }
                    });
});

            </script>
            <script>

                <script>
                    <script>
                        $(document).ready(function () {
    var mainHeader = $(".main-header");
                        var subHeader = $(".sub-header");
                        var stickyHeader = $(".sticky-header");
                        var sidebar = $(".sidebar");
                        var offset = mainHeader.offset().top;
                        var sidebarTopPosition = 60; 

                        $(window).scroll(function () {
        var scrollTop = $(window).scrollTop();
                        var mainHeaderHeight = mainHeader.height();
                        var subHeaderHeight = subHeader.height();
                        var totalHeaderHeight = mainHeaderHeight + subHeaderHeight;

        if (scrollTop >= offset + totalHeaderHeight) {
                            stickyHeader.css('display', 'block');
                        sidebarTopPosition = 40; 
        } else {
                            stickyHeader.css('display', 'none');
                        sidebarTopPosition = 60; 
        }

                        sidebar.css('top', sidebarTopPosition + 'px');
    });
});
                    </script>
                    <script>
                    </script>
                    <script>
                    </script>
                    <script>
                        $(document).ready(function() {
            const sidebar = $('.sidebar');
                        const openSidebarButton = $('#open-sidebar');
                        let sidebarOpen = false;
                        openSidebarButton.on('click', function() {
                if (!sidebarOpen) {
                            sidebar.css('transform', 'translateX(0)');
                        sidebarOpen = true;
                } else {
                            sidebar.css('transform', 'translateX(-100%)');
                        sidebarOpen = false;
                }
            });
                        $(document).on('click', function(event) {
                if (sidebarOpen && !$(event.target).closest('.sidebar').length && event.target !== openSidebarButton[0]) {
                            sidebar.css('transform', 'translateX(-100%)');
                        sidebarOpen = false;
                }
            });
        });
                        $(document).ready(function() {
            const sidebar = $('.sidebar');
                        const openSidebarButton = $('#open-sidebar-1');
                        let sidebarOpen = false;
                        openSidebarButton.on('click', function() {
                if (!sidebarOpen) {
                            sidebar.css('transform', 'translateX(0)');
                        sidebarOpen = true;
                } else {
                            sidebar.css('transform', 'translateX(-100%)');
                        sidebarOpen = false;
                }
            });
                        $(document).on('click', function(event) {
                if (sidebarOpen && !$(event.target).closest('.sidebar').length && event.target !== openSidebarButton[0]) {
                            sidebar.css('transform', 'translateX(-100%)');
                        sidebarOpen = false;
                }
            });
        });
                    </script>
  </body>



<script>

$(document).ready(function() {
    function getParameterByName(name, url) {
        if (!url) url = window.location.href;
        name = name.replace(/[\[\]]/g, "\\$&");
        var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
            results = regex.exec(url);
        if (!results) return null;
        if (!results[2]) return '';
        return decodeURIComponent(results[2].replace(/\+/g, " "));
    }

    $('.comment-main').each(function() {
        const postID = $(this).data('post-id');

        if ($(this).next('.comment-input-container').length === 0) {
            const commentArea = $(this);

            const commentInputContainer = $('<div>').addClass('comment-input-container');
            commentInputContainer.css({
                display: 'flex',
                justifyContent: 'center',
                alignItems: 'center',
                flexDirection: 'column',
                height: '50px'
            });

            const commentInput = $('<textarea>').attr({
                type: 'text',
                id: 'comment-input-' + postID,
                placeholder: 'Add a comment...'
            }).addClass('comment-input');
            commentInputContainer.append(commentInput);

            commentInput.css({
                height: '30px',
                width: '400px',
                background: '#fff',
                border: '1px solid #ccc',
                resize: 'none'
            });

            const buttonContainer = $('<div>');

            const submitButton = $('<button>').text('Submit').addClass('submit-button').css('display', 'none');
            const cancelButton = $('<button>').text('Cancel').addClass('cancel').css('display', 'none');

            buttonContainer.append(submitButton, cancelButton);
            commentInputContainer.append(buttonContainer);

            commentInputContainer.insertAfter(commentArea);

            commentInput.on('click', function() {
                submitButton.css('display', 'inline-block');
                cancelButton.css('display', 'inline-block');

                commentInput.css({
                    height: '60px',
                    width: '425px',
                    textIndent: '2ch',
                    background: '#fff',
                    border: '1px solid #ccc',
                    padding: '0px',
                    resize: 'none',
                    overflowY: 'auto'
                });

                commentInputContainer.css('background', '#f6f6f6');
                commentInputContainer.css('height', '125px');
            });

            submitButton.on('click', function() {
                const commentContent = $(this).closest('.comment-input-container').find('.comment-input').val();
                const postID = getParameterByName('id');
                const username = '<?php echo $_SESSION["username"]; ?>';

                console.log("Data sent in AJAX request:", {
                    commentContent: commentContent,
                    postID: postID,
                    username: username
                });


                
                $.ajax({
                    url: '<?php echo $siteurl; ?>/apiv1-internal/submit_comment.php',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        commentContent: commentContent,
                        postID: postID,
                        username: '<?php echo $_SESSION["username"]; ?>',
                    },
                    success: function(response) {
                        console.log(response);
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            });

            cancelButton.on('click', function() {
                submitButton.css('display', 'none');
                cancelButton.css('display', 'none');

                commentInput.css({
                    height: '30px',
                    width: '400px',
                    background: '#fff',
                    border: '1px solid #ccc'
                });

                commentInputContainer.css('background-color', '#fff');

                commentInputContainer.css('height', '50px');

                commentInput.trigger('blur');
            });

            // Display comments fetched from API
            $.ajax({
                url: '<?php echo $siteurl; ?>/apiv1/fetch_comments.php?id=' +  getParameterByName('id'),
                dataType: 'json',
                success: function(commentsData) {
                    if (commentsData.status === 'success') {
                        const comments = commentsData.comments;
                        const commentsContainer = $('<div>').addClass('comments');
                        comments.forEach(function(comment) {
                            const commentElement = $('<div>').addClass('comment');
                            commentElement.html(`
                                <div class="hacky-fix">
                     <img src="/assets/profilepics/${comment.username}.png" class="comment-picture">
					 <div class="agony">
					  <div class="hacky-fix">
                       <p class="username">${comment.username}</p>
					   <p class="time">${comment.comment_time}</p>
					  </div>
					  <p class="comment-content">${comment.comment_content}</p>
					 </div>
					</div>
                            `);
                            commentsContainer.append(commentElement);
                        });
                        commentArea.append(commentsContainer);
                        hideShowCommentsLink.text('Hide Comments');
                    } else {
                        console.log('No comments found for the post with ID ' + postID);
                    }
                },
                error: function(error) {
                    console.log('Error:', error);
                }
            });
        }
    });
});

 
</script>

<script>

$(document).ready(function() {
  let isHeaderVisible = false;

  $('.settings-icon-side').click(function() {
    console.log("Settings icon clicked");
    if (isHeaderVisible) {
      $('#notificationContainer, .sb-card-body-arrow').css('display', 'none');
    } else {
      $('#notificationContainer, .sb-card-body-arrow').css('display', 'block');
    }
    isHeaderVisible = !isHeaderVisible;
  });
});


$(document).ready(function () {

    $("#showNotification").click(function () {
        $("#notificationContainer, #notificationTriangle").toggle();
    });

    fetchMentions();
    setInterval(fetchMentions, 5000000);
});

function fetchMentions() {
    $("#mentionsContainer").empty();
    $.ajax({
        url: "<?php echo $siteurl; ?>/apiv1/fetch_mentions.php",
        type: "GET",
        data: {
            username: "d" 
        },
        success: function (data) {
            const mentions = JSON.parse(data);

            if (mentions.length > 0) {
                $.each(mentions, function (index, mention) {
                    const mentionDiv = $("<div>").addClass("mention");
                    const pfpImage = $("<img>").attr({
                        src: "./assets/icons/regan.png",
                        alt: "PFP",
                    }).addClass("not-pfp-image");

                    const textContainer = $("<div>").addClass("not-text-container");
                    const usernameDiv = $("<div>").text(mention.sender).addClass("not-username");
                    const contentDiv = $("<div>").text(mention.content).addClass("not-content");

                    textContainer.append(usernameDiv, contentDiv);
                    mentionDiv.append(pfpImage, textContainer);

                    $("#mentionsContainer").append(mentionDiv);

                    mentionDiv.click(function () {
                        dismissMention($(this), mention.post_id);
                    });
                });
            } else {
                $("#mentionsContainer").html("No new mentions.");
            }
        },
    });
}

 function dismissMention(mentionElement, postId) {

    mentionElement.fadeOut(300, function () {
        $(this).remove();
        console.log(postId);
        window.location.href = 'http://localhost:8090/view_post.php?id=' + postId;
    });


    $.ajax({
        url: "http://localhost:8090/apiv1/toggle_notification_status.php",
        type: "POST",
        data: {
            username: "d",
            post_id: postId
        },
        success: function (response) {
        },
        error: function (xhr, status, error) {
        }
    });
}

</script>


</body>

</html>
