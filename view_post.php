<?php
$id = $_GET['id'];
session_start();
if (!isset($_SESSION["username"])) {
    echo '<script>window.location.href = "../user/login.php";</script>';
    exit();
}

include("important/db.php");

$icon = "home";

?>

<?php
if(isset($_GET['trump'])) {
    echo '<link rel="stylesheet" href="assets/css/trump.css">';
}
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

                        <link rel="stylesheet" href="assets/css/2013notes.css">
                        <link rel="stylesheet" href="assets/css/univesalcoolstuff.css">

                        <link rel="stylesheet" href="assets/css/post2.css">

                        <link rel="stylesheet" href="assets/css/writespost.css">

                        <link rel="stylesheet" href="assets/css/headerfix.css">
                        <link rel="icon"type="image/png"href="../assets/important-images/fav.png" />
            </head>

    <link rel="icon"type="image/png"href="/assets/icons/fav.png" />

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

                            <div class="link-preview">
                    </div>

                            <div class="youtube-emded">
                            </div>

                        <div class="comment-main">

                        <div class="comments"></div>

                        </div>

                        </div>

                        </div>
                    </div>
                </div>

                <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
                <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

                <script>
                     $(document).ready(function() {
                        var id = <?php echo json_encode($id); ?>;

                    $.ajax({
                        url: '<?php echo $siteurl; ?>/apiv1/fetch_single_post.php?id=' + id,
                        type: 'GET',
                        dataType: 'json',
                        success: function (userData) {
                            const profileURL = '<?php echo $siteurl; ?>/profile.php?profile=' + userData.username;

                            
                            const anchorElement = $('<a>').attr({
                                href: profileURL,
                                style: 'text-decoration: none; color: inherit;'
                            }).text(userData.username);

                           
                            $('.username-big, .post-username').each(function() {
                                $(this).html(anchorElement.clone()); 
                            });

                            

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
                                userPfpElement.css('background-image', `url(<?php echo $siteurl; ?>/apiv1/fetch_pfp_api.php?name=${postData.username})`);
                                const postPfpElement = $(".post-pfp");
                                postPfpElement.css('background-image', `url(<?php echo $siteurl; ?>/apiv1/fetch_pfp_api.php?name=${postData.username})`);

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

                const $postElement = $('.post');

                if (postData.post_link_url) {
                    $.getJSON('<?php echo $siteurl; ?>/apiv1/fetch_metadata.php?url=' + encodeURIComponent(postData.post_link_url) + '&format=json', function (metadata) {
                        const linkPreviewContainer = $('<div>', { class: 'link-preview' });

                        const faviconContainer = $('<div>', { class: 'favicon-container' });
                        const faviconImg = $('<img>', {
                            src: metadata.image,
                            alt: 'Favicon',
                            class: 'favicon-img'
                        });
                        faviconContainer.append(faviconImg);

                        const contentContainer = $('<div>', { class: 'content-container' });
                        const title = $('<h2>');
                        const titleLink = $('<a>', {
                            href: postData.post_link_url,
                            text: metadata.title,
                            target: '_blank'
                        });
                        title.append(titleLink);

                        const linkText = $('<p>', {
                            text: postData.post_link_url,
                            class: 'link-text'
                        });
                        contentContainer.append(title, linkText);

                        linkPreviewContainer.append(faviconContainer, contentContainer);
                        $('.post .link-preview').append(linkPreviewContainer);

                        const containerWidth = linkPreviewContainer.width();
                        const faviconWidth = containerWidth * 0.3;
                        const contentWidth = containerWidth * 0.8;
                        faviconContainer.width(faviconWidth);
                        contentContainer.width(contentWidth);

                        const maxFaviconHeight = 50;
                        const maxFaviconWidth = containerWidth * 0.3;
                        faviconImg.css({
                            'max-width': maxFaviconWidth + 'px',
                        });

                        if (contentContainer.height() > 200) {
                            contentContainer.css('height', '200px');
                            contentContainer.css('overflow', 'hidden');
                        }
                    });
                }

                if (postData.post_link && postData.post_link.includes("youtube.com/embed")) {
                    const iframeHTML = '<iframe width="99.75%" height="315" frameborder="0" allowfullscreen></iframe>';
                    $postElement.find('.youtube-emded').html(iframeHTML);

                    const protocol = window.location.protocol;
                    if (protocol === 'https:' && !postData.post_link.startsWith('https:')) {
                        postData.post_link = postData.post_link.replace(/^http:/, 'https:');
                    }

                    $postElement.find('.youtube-emded iframe').attr('src', postData.post_link);
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
        let singlePostData;

        function getParameterByName(name, url) {
            if (!url) url = window.location.href;
            name = name.replace(/[\[\]]/g, "\\$&");
            var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
                results = regex.exec(url);
            if (!results) return null;
            if (!results[2]) return '';
            return decodeURIComponent(results[2].replace(/\+/g, " "));
        }

        function fetchSinglePostData(callback) {
        $.ajax({
            url: '<?php echo $siteurl; ?>/apiv1/fetch_single_post.php?id=' + getParameterByName('id'),
            type: 'GET',
            dataType: 'json',
            success: function(postData) {
                callback(postData);
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }

    $('.comment-main').each(function() {
        const postID = $(this).data('post-id');

        if ($(this).next('.comment-input-container').length === 0) {
            const commentArea = $(this);

            fetchSinglePostData(function(postData) {

            const plusOneUsernamesString = postData.plus_one_usernames || '';
            const isLikedByCurrentUser = plusOneUsernamesString.includes('<?php echo $_SESSION["username"];?>');

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
                background: '#fff',
                border: '1px solid #ccc',
                resize: 'none'
            });

            const buttonContainer = $('<div>');

            const submitButton = $('<button>').text('Submit').addClass('submit-button').css('display', 'none');
            const cancelButton = $('<button>').text('Cancel').addClass('cancel').css('display', 'none');

            plusOneIcon = $('<div>').addClass('plus-one-icon').attr('id', isLikedByCurrentUser ? 'liked-icon' : '');
            const plusOneSpan = $('<span>').attr('id', 'georgewallace').text(`+${postData.plus_one}`);
            plusOneIcon.append(plusOneSpan);

            buttonContainer.append(submitButton, cancelButton, plusOneIcon); 
            commentInputContainer.append(buttonContainer);

            commentInputContainer.insertAfter(commentArea);


            commentInput.on('click', function() {
                submitButton.css('display', 'inline-block');
                cancelButton.css('display', 'inline-block');

                
                $('.plus-one-icon').hide();

                commentInput.css({
                    height: '60px',
                    width: '500px',
                    textIndent: '2ch',
                    background: '#fff',
                    border: '1px solid #ccc',
                    padding: '0px',
                    resize: 'none',
                    overflowY: 'auto',
                    left: '1%',
                    top: '1px'
                });

                commentInputContainer.css('background', '#f6f6f6');
                commentInputContainer.css('height', '150px');
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

            $(buttonContainer).find('.plus-one-icon').click(function() {
               var username = '<?php echo $_SESSION["username"];?>';

               $.ajax({
                    url: '<?php echo $siteurl; ?>/apiv1/add_plus_one.php',
                    type: 'POST',
                    data: { add_plus_one: true, id: postData.id, username: username
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

                $('.plus-one-icon').show();

                commentInput.css({
                    height: '30px',
                    width: '400px',
                    background: '#fff',
                    border: '1px solid #ccc',
                    left: '17%',
                    top: '27%'
                });

                commentInputContainer.css('background-color', '#fff');

                commentInputContainer.css('height', '50px');

                commentInput.trigger('blur');
            });
        });


            $.ajax({
                url: '<?php echo $siteurl; ?>/apiv1/fetch_comments.php?id=' +  getParameterByName('id'),
                dataType: 'json',
                success: function(commentsData) {
                    if (commentsData.status === 'success') {
                        const comments = commentsData.comments;
                        const commentsContainer = $('.comments');
                        comments.forEach(function(comment) {
                            const commentElement = $('<div>').addClass('comment');
                            commentElement.html(`
                                <div class="hacky-fix">
                     <img src="<?php echo $siteurl; ?>/apiv1/fetch_pfp_api.php?name=${comment.username}" class="comment-picture">
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

</body>

</html>