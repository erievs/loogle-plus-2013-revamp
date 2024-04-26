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
    fetch('<?php echo $siteurl; ?>/apiv1/fetch_posts_api.php')
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
    <div class="write-post">

    <div class="level-1">

    <div class="pfp-write-post" style="display: none;">
    <img src="<?php echo $siteurl; ?>/apiv1/fetch_pfp_api.php?name=<?php echo $_SESSION["username"];?>" alt="" class="round-image">
    </div>

    <textarea id="postTextArea" placeholder="Share what's new..."></textarea>
        <div id="triangle" class="triangle"></div>
    </div>

    </div>

    <div id="fileDrop" class="file-drop"">

</div>

    <div class="level-2">

    <div class="attach-photos-row">
            <div class="attach">
                Attach:
            </div>

            <div id="mymotherquestionmark" class="photo-icon" >
            <p style="position: relative; top: -7px; left: 15px;">
            Photos</p>
            </div>

            <div class="photo-icon" id="bobisbackbutfuckhim">
            <p style="position: relative; top: -7px; left: 15px;">
            Link</p>
            </div>

            <div class="photo-icon" id="videosarebackbaby">
            <p style="position: relative; top: -8px; left: 15px;">
            Video</p>
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
    

    <div class="add-link" style="display: none;">
    
    <p id="pthingy1">
    Add Link:
    </p>

    <textarea class="add-link1" id="al1" style="height: 46px; width: 79%;margin-left: 120px;margin-top: 8px;position: relative;top: 20px;overflow: hidden;border: 1px solid rgba(10, 10, 10, 0.1); font-weight: bold;
    font-size: 14px;" placeholder="Insert your link here, it must start with http/https or it wont send."></textarea>

    </div>


    <div class="add-video" style="display: none;">
    
    <p id="pthingy1">
    Add Video:
    </p>

     <textarea class="add-link1" id="al2" style="height: 46px; width: 79%;margin-left: 120px;margin-top: 8px;position: relative;top: 20px;overflow: hidden;border: 1px solid rgba(10, 10, 10, 0.1); font-weight: bold;
    font-size: 14px;" placeholder="Insert your youtube video here, it must be a standerd youtube url or it wont send."></textarea>

    </div>

    </div>
    <div class="post-create-icons">
        <div class="iconstuff">
            <div class="image-write"></div>
            <br>
            <br>
            <span style="color: black; font-weight: bold;">Text</span>
        </div>
        
        <div class="iconstuff">
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

function getQueryParameter(name) {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.has(name);
}


function getQueryParameter(name) {
const urlParams = new URLSearchParams(window.location.search);
return urlParams.has(name);
}

function getQueryParameterValue(name) {
const urlParams = new URLSearchParams(window.location.search);
return urlParams.get(name);
}

 if (getQueryParameter('linkopen') || getQueryParameter('write_post_link_open')) {
        console.log('Link open query parameter is present');
   
        const urlParam = getQueryParameterValue('url');
    if (urlParam) {
        $('#al1').val(urlParam);
    }


        if (!postCreateMoved) {
        const $postCreate = $('.post-create'); 
        const $writePostDiv = $('.write-post-expanded'); 
        const $writePostImage = $('.pfp-write-post');
        const $writePostLevel2 = $('.level-2');
        const $writePostLevel2p5 = $('.level-2.5');
        const $writePostLeve3 = $('.level-3');
        const $writePostPhotoIcon = $('.photo-icon');
        const $writePostLinkIcon = $('#bobisbackbutfuckhim');
        const $writePostPhotoRealIcon = $('#mymotherquestionmark ');
        const $addPhotostext = $('.add-photos');
        const $addLinktext = $('.add-link'); 
        const $addVideotext = $('.add-video');
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

            $addLinktext.show();


            $postCreate.css({
                background: '#f6f6f6',
                padding: '10px',
                width: '650px',
                height: '350px',
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
            $('.triangle').hide();

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

         $writePostLinkIcon.click(function () {
         $postCreate.css({
           height: '350px'
         });

         

        $level4.css({
        top: '80px'
         });
       });

       
    }
 }


 if (getQueryParameter('videoopen') || getQueryParameter('write_post_video_open')) {
        console.log('Link open query parameter is present');
   
        const urlParam = getQueryParameterValue('url');
    if (urlParam) {
        $('#al2').val(urlParam);
    }

        if (!postCreateMoved) {
        const $postCreate = $('.post-create'); 
        const $writePostDiv = $('.write-post-expanded'); 
        const $writePostImage = $('.pfp-write-post');
        const $writePostLevel2 = $('.level-2');
        const $writePostLevel2p5 = $('.level-2.5');
        const $writePostLeve3 = $('.level-3');
        const $writePostPhotoIcon = $('.photo-icon');
        const $writePostLinkIcon = $('#bobisbackbutfuckhim');
        const $writePostPhotoRealIcon = $('#mymotherquestionmark ');
        const $addPhotostext = $('.add-photos');
        const $addLinktext = $('.add-link'); 
        const $addVideotext = $('.add-video');
        const $uploadButton = $('.upload-button');
        const $attach = $('.attach');
        const $photo = $('.photo-icon');
        const $level4 = $('.level-4');
        const $box = $('.fileDrop');
        const $attachRow = $('.attach-photos-row');

        const destination = $writePostDiv.position();


        $postCreate.animate({
            left: destination.left,
            top: destination.top,
            opacity: 0
        }, 300, function () {

            $writePostDiv.append($postCreate);

            $addVideotext.show();


            $postCreate.css({
                background: '#f6f6f6',
                padding: '10px',
                width: '650px',
                height: '350px',
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
            $('.triangle').hide();

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

         $writePostLinkIcon.click(function () {
         $postCreate.css({
           height: '350px'
         });

         

        $level4.css({
        top: '80px'
         });
       });

       
    }
 }

$('#postTextArea').click(function () {

    if (!postCreateMoved) {
        const $postCreate = $('.post-create'); 
        const $writePostDiv = $('.write-post-expanded'); 
        const $writePostImage = $('.pfp-write-post');
        const $writePostLevel2 = $('.level-2');
        const $writePostLevel2p5 = $('.level-2.5');
        const $writePostLeve3 = $('.level-3');
        const $writePostPhotoIcon = $('.photo-icon');
        const $writePostLinkIcon = $('#bobisbackbutfuckhim');
        const $writePostPhotoRealIcon = $('#mymotherquestionmark');
        const $writePostVideoIcon = $('#videosarebackbaby');
        const $addPhotostext = $('.add-photos');
        const $addLinktext = $('.add-link');
        const $addVideotext = $('.add-video');
        const $uploadButton = $('.upload-button');
        const $attach = $('.attach');
        const $photo = $('.photo-icon');
        const $level4 = $('.level-4');
        const $box = $('.fileDrop');
        const $attachRow = $('.attach-photos-row');

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
            $('.triangle').hide();

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

        // THIS IS THE WRITE POST LINK NOT PHOTO, NCP - THE DUMB NUTS

        $writePostLinkIcon.click(function () {


            $('.attach-photos-row').hide();

        $addLinktext.show();
  

            $postCreate.css({
                        height: '350px'
                    });


            $level4.css({
                        top: '80px'
            });
            
        })

        $writePostVideoIcon.click(function () {

            $attachRow.hide();

        $addVideotext.show();

 

        $postCreate.css({
            height: '350px'
        });
        $level4.css({
            top: '80px'
         });

        })

        $writePostPhotoRealIcon.click(function () {

            $("#fileDrop").toggle(function () {
                if ($(this).is(":visible")) {
                    $postCreate.css({
                        height: '350px'
                    });

                    $addPhotostext.show();

                    $writePostLeve3.show();
                    $uploadButton.show();

                    $attachRow.hide();

                    $level4.show();
                    $box.hide();
                    $photo.css({
                        display: 'none'
                    });
                    $attach.css({
                        display: 'none'
                    });
                    $level4.css({
                        top: '80px'
                    });

                } else {
                    $addPhotostext.css({
                        display: 'none'
                    });
                    $writePostLevel2p5.css({
                        display: 'block'
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
const postLink = $('#al1').val(); 
const postVideo = $('#al2').val(); 


const username = '<?php echo isset($_SESSION["username"]) ? $_SESSION["username"] : ""; ?>';

if (!postContent && $('#fileUploadInput')[0].files.length === 0 && !postLink && !postVideo) {
console.log('Please enter text, select an image, add a link, or upload a video before sharing.');
return;
}


const formData = new FormData();
formData.append('username', username);
formData.append('postContent', postContent);

if (postLink) { 
    formData.append('post_link_url', postLink);
}


if (postVideo) { 
    formData.append('post_link', postVideo);
}

if ($('#fileUploadInput')[0].files.length > 0) {
    formData.append('postImage', $('#fileUploadInput')[0].files[0]);
}

$.ajax({
    type: 'POST',
    url: '<?php echo $siteurl; ?>/apiv1-internal/submit_post_api.php',
    data: formData,
    processData: false,
    contentType: false,
    dataType: 'json',
    success: function (response) {
        smoothReload(500);

        if (response.status === 'success') {
            console.log(response.message);
        } else {
          
            console.log(response.message);
        }
    },
    error: function (error) {
  
        console.log('Error:', error);
    }
});
    }); 
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

            submitButton.css('display', 'inline-block');
            cancelButton.css('display', 'inline-block');

            $(this).closest('.comment-input-container').find('.plus-one-icon').hide();



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
                
        },
         error: function(xhr, status, error) {
            console.error(xhr.responseText);
            }
        });
        });

    cancelButton.on('click', function() {

    submitButton.css('display', 'none');
    cancelButton.css('display', 'none');

    commentInputContainer.css('background-color', '#fff');
    $('.plus-one-icon').show();


   commentInput.css({
      height: '30px',
      width: '275px',
      left: '17%'
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

<script>
$(document).ready(function() {
    $('#al1').on('input', function() {
        var linkInput = $(this).val().trim();
        if (!linkInput.startsWith('http://')) {
            linkInput = 'http://' + linkInput;
            $(this).val(linkInput);
        }
    });
});
</script>

</body>
</html>