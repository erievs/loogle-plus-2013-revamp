<?php
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
 
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>

    <title>Loogle+</title>
	<link rel="stylesheet" href="assets/css/2013isamess.css">
	<link rel="stylesheet" href="assets/css/2013indexres.css">
	<link rel="stylesheet" href="assets/css/2013notes.css">
    <link rel="stylesheet" href="assets/css/univesalcoolstuff.css">
    <link rel="stylesheet" href="assets/css/headerfix.css">
    <link rel="stylesheet" href="assets/css/whatshotregan.css">
    <link rel="icon" 
      type="image/png" 
      href="assets/important-images/fav.png" />

</head>
<body>

<?php require_once("inc/topstuffs.php")?>



<div class="banner">
    <!-- LOADED IN A SUCH   -->
</div>

<div class="write-post-expanded">

</div>

<div class="content">
    <div class="container" id="posts-container">

    </div>
</div>

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
function formatTime(timestamp) {
    const date = new Date(timestamp);
    const options = { month: 'long', day: 'numeric', year: 'numeric' };
    return date.toLocaleString('en-US', options);
}

    function fetchPosts() {
    fetch('<?php echo $siteurl; ?>/apiv1/whats_hot.php')
        .then(response => response.json())
        .then(data => {
            const postsContainer = document.getElementById('posts-container');

            postsContainer.innerHTML = '';

let numColumns = 3; 
const screenWidth = window.innerWidth;

const urlParams = new URLSearchParams(window.location.search);
const forceColParam = urlParams.get('forcecol');

if (forceColParam && !isNaN(forceColParam)) {
    numColumns = parseInt(forceColParam);
} else {
    if (screenWidth <= 1599) {
        numColumns = 2; 
    } else if (screenWidth <= 720) {
        numColumns = 1; 
    }
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
<div id="bob-post-create" class="write-post">

<h2 style="color: #a5a5a5;">What's hot and recommended</h2>

<b style="color: #454545;font-size: 12px;margin-left: 6px; margin-top: 6px; position: relative; top: 7px;">
These posts are popular on Loogle+</b>

</div> 
`;

columns[0].appendChild(postCreate);

$(document).ready(function () {
let postCreateMoved = false; 
});

const apiEndpoint = '<?php echo $siteurl; ?>/apiv1/fetch_comments.php?id=';

let currentColumnIndex = 0;

for (let i = 0; i < data.length; i++) {
    const post = data[i];
    
    const postElement = document.createElement('div');
    postElement.className = 'post';
    const formattedTime = formatTime(post.created_at);

    const plusOneUsernamesString = post.plus_one_usernames || '';
    const isLikedByCurrentUser = plusOneUsernamesString.includes('<?php echo $_SESSION["username"];?>');
    


    postElement.innerHTML = `
    <div class="post-main">  
     <div class="hacky-fix">
     <img src="<?php echo $siteurl; ?>/apiv1/fetch_pfp_api.php?name=${post.username}" class="post-file-picture">
      <div class="aaaaaa">
       <div class="post-top">
       <a href="<?php echo $siteurl; ?>/profile.php?profile=${post.username}">
        <p class="username">${post.username}</p>
       </a>
        </div>
       <div class="post-meta">
        <span>Sharing Publicly &nbsp;</span>
        <a style="color: inherit; text-decoration: none;" href="view_post.php?id=${post.id}">
         <span class="upload-time">- ${formattedTime}</span>
        </a>
      </div>
      </div>
     </div>
        <div class="post-content-container">
            <p class="post-content">${post.content}</p>
            <img class="post-image" src="${post.image_url}" alt="">

            <div class="link-preview">
            </div>
         
            <div class="youtube-emded">
            </div>

        </div>

    </div>

    </div>
    
  `;

if (post.post_link && post.post_link.includes("youtube.com/embed")) {
const iframeHTML = '<iframe width="99.75%" height="315" frameborder="0" allowfullscreen></iframe>';
$(postElement).find('.youtube-emded').html(iframeHTML);

const protocol = window.location.protocol;
if (protocol === 'https:' && !post.post_link.startsWith('https:')) {
    post.post_link = post.post_link.replace(/^http:/, 'https:');
}

$(postElement).find('.youtube-emded iframe').attr('src', post.post_link);
}

if (post.post_link_url) {
    $.getJSON('<?php echo $siteurl; ?>/apiv1/fetch_metadata.php?url=' + encodeURIComponent(post.post_link_url) + '&format=json', function(metadata) {
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
            href: post.post_link_url, 
            text: metadata.title, 
            target: '_blank' 
        });
        title.append(titleLink);
        const linkText = $('<p>', { 
            text: post.post_link_url,
            class: 'link-text' 
        });
        contentContainer.append(title, linkText);
        linkPreviewContainer.append(faviconContainer, contentContainer);
        $(postElement).find('.link-preview').append(linkPreviewContainer);
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
    })
    .fail(function(jqxhr, textStatus, error) {
        const err = textStatus + ", " + error;
        console.log("Request Failed: " + err);
    });
}


postElement.dataset.postId = post.id;
postElement.dataset.plusOne = post.plus_one;
postElement.dataset.isLikedByCurrentUser = isLikedByCurrentUser;

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
                <div class="hacky-fix">
                 <img src="<?php echo $siteurl; ?>/apiv1/fetch_pfp_api.php?name=${comment.username}" class="comment-picture">
                 <div class="agony">
                  <div class="hacky-fix">
                  <a href="<?php echo $siteurl; ?>/profile.php?profile=${comment.username}"  <p class="username">${comment.username}</p></a>
                   <p class="time">${comment.comment_time}</p>
                  </div>
                  <p class="comment-content">${comment.comment_content}</p>
                 </div>
                </div> 
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

    
     if ($(this).next('.comment-input-container').length === 0) {
        
        const postElement = $(this).closest('.post'); 
        const postID = postElement.data('post-id'); 
        const plusOneIs = postElement.data('plus-one');
        const isLikedByCurrentUser = Boolean(postElement.data('is-liked-by-current-user'));


        console.log(postID);

        const commentInputContainer = $('<div>').addClass('comment-input-container');
            commentInputContainer.css({
            display: 'flex',
            justifyContent: 'center',
            alignItems: 'center',
            flexDirection: 'column',
            height: '50px', 
            position: 'relative' 
        });



        const plusOneContainer = $('<div>').addClass('plus-one-container');
            plusOneContainer.css({
            position: 'absolute',
            top: '5px',
            right: '5px' 
        });

        const plusOneIcon = $('<div>').addClass('plus-one-icon').attr('id', isLikedByCurrentUser ? 'liked-icon' : '');
        const plusOneSpan = $('<span>').attr('id', 'georgewallace').text(`+${plusOneIs}`);

        plusOneIcon.append(plusOneSpan);
        plusOneContainer.append(plusOneIcon);

        $(plusOneContainer).find('.plus-one-icon').click(function() {
           var username = '<?php echo $_SESSION["username"];?>';

           $.ajax({
           url: '<?php echo $siteurl; ?>/apiv1/add_plus_one.php',
           type: 'POST',
           data: { add_plus_one: true, id: postID, username: username },
           success: function(response) {
            console.log(response);
            location.reload(); 
           },
            error: function(xhr, status, error) {
            console.error(xhr.responseText);
            }
        });
            });


        const commentInput = $('<textarea>').attr({
            type: 'text',
            id: 'comment-input-' + postID, 
            placeholder: 'Add a comment...'
        }).addClass('comment-input');
        commentInputContainer.append(commentInput);
        commentInputContainer.append(plusOneContainer);
     

        commentInput.css('height', '30px');
        commentInput.css('width', '275px');
        commentInput.css('background', '#fff');
        commentInput.css('border', '1px solid #ccc');
        commentInput.css('resize', 'none');

        const buttonContainer = $('<div>');

        const submitButton = $('<button>').text('Submit').addClass('submit-button').css('display', 'none');

        const cancelButton = $('<button>').text('Cancel').addClass('cancel').css('display', 'none');

        buttonContainer.append(submitButton, cancelButton);

        commentInputContainer.append(buttonContainer);

        $(this).after(commentInputContainer);

        commentInput.on('click', function() {

            $(this).closest('.comment-input-container').find('.plus-one-icon').show();

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

            commentInput.css('left', '0%')

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
            
        url: '<?php echo $siteurl; ?>/apiv1-internal/submit_comment.php',
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
      width: '275px',
      left: '17%'
    });

    commentInputContainer.css('background-color', '#fff');

    $('.plus-one-icon').show();


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
            if (!$(event.target).closest('#fileDrop').length && !$(event.target).is($writePostPhotoRealIcon) && !$(event.target).is($uploadButton) ) {
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

    smoothReload(1000);

});

const commentMain = $('.comment-main');

fetchPosts();
setInterval(fetchPosts, 600000);

function smoothReload(delay) {
$("body").fadeOut(delay, function() {
    history.replaceState({}, document.title, window.location.pathname);
    location.reload();
});
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

$(document).ready(function() {
    $(document).keydown(function(e) {
        if (e.key === "Escape") {
            $(".sidebar").css("transform", "translateX(-100%)");
        }
    });


    $(document).on("click dblclick", function(e) {
        if (!$(e.target).closest(".sidebar").length || e.type === "dblclick") {
            $(".sidebar").css("transform", "translateX(-100%)");
        }
    });
});
</script>

<script>
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

$(document).ready(function() {
    $(document).keydown(function(e) {
        if (e.key === "Escape") {
            $(".sidebar").css("transform", "translateX(-100%)");
        }
    });


    $(document).on("click dblclick", function(e) {
        if (!$(e.target).closest(".sidebar").length || e.type === "dblclick") {
            $(".sidebar").css("transform", "translateX(-100%)");
        }
    });
});

</script>

<script>
    $(document).ready(function() {
        $(".dropdown-toggle").click(function(e) {
            e.preventDefault(); 
            var $dropdownMenu = $(this).next(".dropdown-menu");
            $dropdownMenu.toggleClass("show");
        });

        $(document).click(function(e) {
            if (!$(e.target).closest(".dropdown-toggle").length && $(".dropdown-menu").hasClass("show")) {
                $(".dropdown-menu").removeClass("show");
            }
        });
    });
</script>

</body>
</html>