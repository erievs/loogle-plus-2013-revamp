<?php
session_start();
if (!isset($_SESSION["username"])) {
    echo '<script>window.location.href = "../user/login.php";</script>';
    exit();
}

include("important/db.php");

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  
    <link rel="stylesheet" href="assets/css/2013isamess.css">
    <link rel="stylesheet" href="assets/css/2013indexres.css">
    <link rel="stylesheet" href="assets/css/2013profile.css">
</head>
<body>


<div class="sidebar">
    <ul>
        <li><span class="icon">Home</span></li>
        <li><span class="icon">Profile</span></li>
        <li><span class="icon">People</span></li>
        <li><span class="icon">Photos</span></li>
        <li><span class="icon">What's Hot</span></li>
        <li><span class="icon">Communities</span></li>
        <li><span class="icon">Events</span></li>
        <li><span class="icon">Settings</span></li>
    </ul>
</div>

<div class="sub-header">
<span id="open-sidebar" class="home-h-icon home-icon"></span>

    <span class="home-icon">Home </span>
    <span class="arrow-icon"> ></span>
    <div class="menu">
        <span class="divider"></span>
        <ul class="nav nav-tabs">
            <li role="presentation" class="active"><a href="#">All</a></li>
            <li role="presentation"><a href="#">Family</a></li>
            <li role="presentation"><a href="#">Friends</a></li>
            <li role="presentation" class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
                   aria-expanded="false">
                    More <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="#">Option 1</a></li>
                    <li><a href="#">Option 2</a></li>
                    <li><a href="#">Option 3</a></li>
                </ul>
            </li>
        </ul>
    </div>
</div>



<div class="banner">
    <!-- Banner content will be loaded dynamically -->
</div>


<div class="sticky-header" style="display: none;">
    <div class="menu">
    <span id="open-sidebar-1" class="home-h-icon home-icon"></span>
    <span class="home-icon">Home </span>
    <span class="arrow-icon"> ></span>
        <span class="divider"></span>
        <ul class="nav nav-tabs" style="margin:0 auto;">
            <li role="presentation" class="active"><a href="#">All</a></li>
            <li role="presentation"><a href="#">Family</a></li>
            <li role="presentation"><a href="#">Friends</a></li>
            <li role="presentation" class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
                   aria-expanded="false">
                    More <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="#">Placeholer</a></li>
                    <li><a href="#">Placeholer</a></li>
                    <li><a href="#">Placeholer</a></li>
                </ul>
            </li>
        </ul>
    </div>
</div>


<div class="write-post-expanded">

</div>

<div class="content">
    <div class="container" id="posts-container">

    </div>
</div>





<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>



</script>

<script>


function formatTime(timestamp) {
    const date = new Date(timestamp);
    const options = { month: 'long', day: 'numeric', year: 'numeric' };
    return date.toLocaleString('en-US', options);
}

var urlParams = new URLSearchParams(window.location.search);
        var profileValue = urlParams.get('profile');

var apiUrl = 'http://localhost:8090/apiv1/fetch_posts_api.php?username=' + encodeURIComponent(profileValue);


    function fetchPosts() {
    fetch(apiUrl)
        .then(response => response.json())
        .then(data => {
            const postsContainer = document.getElementById('posts-container');

            postsContainer.innerHTML = '';

let numColumns = 3; 
const screenWidth = window.innerWidth;

if (screenWidth <= 1599) {
    numColumns = 2; 
} else if (screenWidth <= 720) {
    numColumns = 1; 
}

const columns = [];
for (let i = 0; i < numColumns; i++) {
    const column = document.createElement('div');
    column.className = 'column';
    columns.push(column);
    postsContainer.appendChild(column);
}

            const postCreate = document.createElement('div');
postCreate.className = 'post-create';
postCreate.innerHTML = `
    <div class="write-post">

    <div class="level-1">

    <div class="pfp-write-post" style="display: none;">
    <img src="assets/icons/default.jpg" alt="" class="round-image">
    </div>

    <textarea id="postTextArea" placeholder="Share what's new..."></textarea>
        <div class="triangle"></div>
    </div>

    </div>

    <div id="fileDrop" class="file-drop"">

</div>

    <div class="level-2">

    <div class="attach-photos-row">
            <div class="attach">
                Attach:
            </div>
            <div class="photo-icon">
            <p style="position: relative;
top: -7px;
left: 15px;">Photos</p>
            </div>

    </div>

    <div class="level-3" style="display: none;">

    <div class="add-photos">
            Add Photos:
        </div>

        <input type="file" id="fileUploadInput" accept="image/*" style="display: none;">

        <input type="file" id="fileUploadInput" accept="image/*" style="display: none">
<button class="upload-button" id="openFileDialog">Upload from computer</button>

    </div>

    </div>
    <div class="post-create-icons">
        <div>
            <div class="image-write"></div>
            <br>
            <br>
            <span style="color: black; font-weight: bold;">Text</span>
        </div>
        |
        <div>
            <div class="image-photo"></div>
            <br>
            <br>
            <span>Photos</span>
        </div>

    </div>

    <div class="level-4" style="background: #fff;">
    <button class="share-button" style="background: #55a644;">Share</button>
    <button class="cancel-button"  id="cancelButton" style="background: #fbfbfb; color: black;">Cancel</button>
    </div>
`;

    columns[0].appendChild(postCreate);

    $(document).ready(function () {
    let postCreateMoved = false; 

    $('#postTextArea').click(function () {

        if (!postCreateMoved) {
            const $postCreate = $('.post-create'); 
            const $writePostDiv = $('.write-post-expanded'); 
            const $writePostImage = $('.pfp-write-post');
            const $writePostLevel2 = $('.level-2');
            const $writePostLeve3 = $('.level-3');
            const $writePostPhotoIcon = $('.photo-icon');
            const $addPhotostext = $('.add-photos');
            const $uploadButton = $('.upload-button');
            const $attach = $('.attach');
            const $photo = $('.photo-icon');
            const $level4 = $('.level-4');
            const $box = $('.fileDrop');

            const destination = $writePostDiv.position();

            $postCreate.animate({
                left: destination.left,
                top: destination.top,
                opacity: 0
            }, 300, function () {

                $writePostDiv.append($postCreate);

                $postCreate.css({
                    background: '#f6f6f6',
                    padding: '10px',
                    width: '650px',
                    height: '300px',
                    border: '1px solid rgba(10, 10, 10, 0.1)',
                    position: 'relative',
                    margin: '0 auto',
                    marginTop: '40px',
                    left: '0',
                    top: '0',
                    opacity: '1',
                    'box-shadow': '3px 0 33px 0px #000',
                });

                $('.post-create-icons').hide();

                $writePostDiv.show();
                $level4.show();
            });

            $('#postTextArea').css({
                width: '75%',
                left: '22%',
                position: 'relative',
                border: '1px solid rgba(10, 10, 10, 0.1)',
            });

            $level4.css({
                top: '90px'
            });

            $writePostImage.show();
            $writePostLevel2.show();
            $level4.show();
            $box.hide();

            postCreateMoved = true;

            $writePostPhotoIcon.click(function () {

                $("#fileDrop").toggle(function () {
                    if ($(this).is(":visible")) {
                        $postCreate.css({
                            height: '300px'
                        });

                        $addPhotostext.show();
                        $writePostLeve3.show();
                        $uploadButton.show();
                        $level4.show();
                        $box.hide();
                        $photo.css({
                            display: 'none'
                        });
                        $attach.css({
                            display: 'none'
                        });
                        $level4.css({
                            top: '0px'
                        });
                    } else {
                        $addPhotostext.css({
                            display: 'none'
                        });
                        $writePostLevel2.css({
                            height: '300px',
                            display: 'block'
                        });
                        $writePostLevel3.css({
                            display: 'none'
                        });
                        $level4.css({
                        top: '90px'
                    });
                    }
                });
            });

            $(document).on('click', function (event) {
                if (!$(event.target).closest('#fileDrop').length && !$(event.target).is($writePostPhotoIcon) && !$(event.target).is($uploadButton) ) {
                    $("#fileDrop").hide();
                    $postCreate.css({
                        height: '300px' 
                    });
                    $writePostLevel2.css({
                        height: 'auto',
                        display: 'block'
                    });
                    $photo.show();
                    $attach.show();
                    $addPhotostext.hide();
                    $uploadButton.hide();
                    $box.hide();
                    $level4.css({
                        top: '90px'
                    });
                }
            });
        }
    });

    $('#cancelButton').click(function () {
        smoothReload(500);
});

$('#fileDrop').on('dragover', function (e) {
        e.preventDefault();
        $(this).addClass('dragover'); 
    });

    $('#fileDrop').on('dragleave', function (e) {
        e.preventDefault();
        $(this).removeClass('dragover'); 
    });

    $('#fileDrop').on('drop', function (e) {
        e.preventDefault();
        $(this).removeClass('dragover'); 

        const files = e.originalEvent.dataTransfer.files;

        if (files.length > 0) {
            handleFiles(files);
        }
    });

    function handleFiles(files) {
        for (const file of files) {
            const reader = new FileReader();
            reader.onload = function (e) {
                const imageData = e.target.result; 

            };
            reader.readAsDataURL(file);
        }
    }

$('#openFileDialog').click(function () {
    const fileInput = document.getElementById('fileUploadInput');
    fileInput.click(); 
});

$('#fileUploadInput').change(function () {

    const selectedFile = $(this)[0].files[0];
    if (selectedFile) {
        console.log('Selected file:', selectedFile.name);
    }
});

$('.share-button').click(function () {

    const postContent = $('#postTextArea').val();
    const username = '<?php echo isset($_SESSION["username"])
        ? $_SESSION["username"]
        : ""; ?>';

    if (!postContent && $('#fileUploadInput')[0].files.length === 0) {

        console.log('Please enter text or select an image before sharing.');
        return; 
    }

    const formData = new FormData();
    formData.append('username', username); 
    formData.append('postContent', postContent);

    if ($('#fileUploadInput')[0].files.length > 0) {
        formData.append('postImage', $('#fileUploadInput')[0].files[0]);
    }

    $.ajax({
        type: 'POST',
        url: 'http://localhost:8090/apiv1-internal/submit_post_api.php', 
        data: formData,
        processData: false, 
        contentType: false, 
        dataType: 'json',
        success: function (response) {
            smoothReload(500);

            if (response.status === 'success') {
                smoothReload(500);
                location.reload
                console.log(response.message);
            } else {
                smoothReload(500);
                console.log(response.message);
            }
        },
        error: function (error) {
            smoothReload(500);
            console.log('Error:', error);
        }
    });
});

});

const apiEndpoint = 'http://localhost:8090/apiv1/fetch_comments.php?id=';

let currentColumnIndex = 0;

for (let i = 0; i < data.length; i++) {
    const post = data[i];
    const postElement = document.createElement('div');
    postElement.className = 'post';
    const formattedTime = formatTime(post.created_at);

    postElement.innerHTML = `
        <div class="post-main">  
            <div class="post-top">
                <p class="username">${post.username}</p>
            </div>
            <div class="post-meta">
                <span>Sharing Publicly &nbsp;</span>
                <a style="color: inherit; text-decoration: none;" href="view_post.php?id=${post.id}">
                    <span class="upload-time">- ${formattedTime}</span>
                </a>
            </div>
            <div class="post-content-container">
                <p class="post-content">${post.content}</p>
                <img class="post-image" src="${post.image_url}" alt="">
            </div>
        </div>
        
    `;

    postElement.dataset.postId = post.id;




    columns[currentColumnIndex].appendChild(postElement);

    const commentArea = document.createElement('div');
    commentArea.className = 'comment-main';

    const hideShowCommentsLink = document.createElement('a');

    hideShowCommentsLink.addEventListener('click', function (e) {
        e.preventDefault();
        const comments = commentArea.querySelector('.comments');
        if (comments.style.display === 'none') {
            comments.style.display = 'block';

        } else {
            comments.style.display = 'none';

        }
    });

    commentArea.appendChild(hideShowCommentsLink);

    postElement.appendChild(commentArea);

    $.ajax({
        url: apiEndpoint + post.id,
        dataType: 'json',
        success: function (commentsData) {
            if (commentsData.status === 'success') {

                $.each(commentsData.comments, function (index, comment) {
                    const commentElement = document.createElement('div');
                    commentElement.className = 'comment';
                    commentElement.innerHTML = `
                    <div class="pfp"></div> 
                    <p class="username">${comment.username}</p>
                    <p class="comment-content">${comment.comment_content}</p>
                    `;

                    commentArea.appendChild(commentElement);
                });
            } else {

                console.log('No comments found for the post with ID ' + post.id);
            }
        },
        error: function (error) {

            console.log('Error:', error);
        }
    });

    $(document).ready(function() {
    $('.comment-main').each(function() {
        const postID = $(this).data('post-id');
        
        if ($(this).next('.comment-input-container').length === 0) {

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
                id: 'comment-input-' + postID, // Set ID with post ID
                placeholder: 'Add a comment...'
            }).addClass('comment-input');
            commentInputContainer.append(commentInput);

            

            commentInput.css('height', '30px');
                commentInput.css('width', '400px');
                commentInput.css('background', '#fff');
                commentInput.css('border', '1px solid #ccc');
                commentInput.css('resize', 'none')

            const buttonContainer = $('<div>');

            const submitButton = $('<button>').text('Submit').addClass('submit-button').css('display', 'none');

            const cancelButton = $('<button>').text('Cancel').addClass('cancel').css('display', 'none');

            buttonContainer.append(submitButton, cancelButton);

            commentInputContainer.append(buttonContainer);

            $(this).after(commentInputContainer);

            commentInput.on('click', function() {

                submitButton.css('display', 'inline-block');
                cancelButton.css('display', 'inline-block');

                commentInput.css('height', '60px');
                commentInput.css('width', '425px');

                commentInput.css('text-indent', '2ch');

                commentInput.css('background', '#fff');
                commentInput.css('border', '1px solid #ccc');

                commentInput.css('background', '#fff');
                commentInput.css('padding', '0px');

                commentInput.css('resize', 'none');

                commentInput.css('overflowY', 'auto')

                commentInputContainer.css('background', '#f6f6f6');

                commentInputContainer.css('height', '125px');
            });

            submitButton.on('click', function() {

                const commentContent = $(this).closest('.comment-input-container').find('.comment-input').val();
                console.log(commentContent);
    const postID = $(this).closest('.post').data('postId');
    const username = '<?php echo $_SESSION["username"]; ?>'; 

    console.log("Data sent in AJAX request:", {
    commentContent: commentContent,
    postID: postID,
    username: username
});

    $.ajax({
        url: 'http://localhost:8090/apiv1-internal/submit_comment.php',
        type: 'POST',
        dataType: 'json',
        data: {
            commentContent: commentContent,
            postID: postID,
            username: username
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
        width: '400px'
    });

    commentInputContainer.css('height', '50px');

    commentInput.css({
        background: '#fff',
        border: '1px solid #ccc'
    });

    commentInput.trigger('blur');
});

        }
    });
});

    currentColumnIndex = (currentColumnIndex + 1) % numColumns;
}

        })
        .catch(error => {
            console.error('Error fetching posts:', error);
        });

        $(document).on('click', function (event) {
                if (!$(event.target).closest('#fileDrop').length && !$(event.target).is($writePostPhotoIcon) && !$(event.target).is($uploadButton) ) {
                    $("#fileDrop").hide();
                    $postCreate.css({
                        height: '300px' 
                    });
                    $writePostLevel2.css({
                        height: 'auto',
                        display: 'block'
                    });
                    $photo.show();
                    $attach.show();
                    $addPhotostext.hide();
                    $uploadButton.hide();
                    $box.hide();
                    $level4.css({
                        top: '90px'
                    });
                }
            });
        }

    $('#cancelButton').click(function () {

                    location.reload();
});

const commentMain = $('.comment-main');

fetchPosts();
setInterval(fetchPosts, 600000);

function smoothReload(delay) {
    setTimeout(function() {
        location.reload();
    }, delay);
}


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

</script>
<script>
        function getUrlParameter(name) {
            name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
            var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
            var results = regex.exec(location.search);
            return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
        };

        var profileValue = getUrlParameter('profile');
        var apiUrl = "http://localhost:8090/apiv1/fetch_banner_api.php?name=" + profileValue;
        var img = $('<img>');
        img.attr('src', apiUrl);
        $(".banner").append(img);

        $(".sub-header").addClass("fixed");

        var scrollThreshold = 50;

        $(".sticky-header").css("display", "none");
                $(".sub-header").css("position", "");
                $(".banner img").css({"height": "150px", "position": "", "z-index": "999"});
        $(window).scroll(function() {
            if ($(this).scrollTop() > scrollThreshold) {
                $(".sticky-header").css("display", "block");
                $(".sub-header").css("position", "fixed");
                $(".banner img").css({"height": "100px", "position": "fixed"});
                $(".sticky-header .nav-tabs > li.active > a").css("margin-top", "-3px");
                $(".nav-tabs").css("border-bottom", "none");
            } else {
                $(".sticky-header").css("display", "none");
                $(".sub-header").css("position", "");
                $(".banner img").css({"height": "150px", "position": "", "z-index": "999"});
            }
        });

</script>



</body>
</html>