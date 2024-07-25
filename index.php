<?php
session_start();

include("important/db.php");

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

<?php
if(isset($_GET['trump'])) {
    echo '<link rel="stylesheet" href="assets/css/trump.css">';
}
?>

<style>
.white-color {
    color: white !important;
}

#bob-loadmore {
  font-size: 18px;
} 

.comment-input {
    padding-top: 3px;
}

textarea {
    padding-top: 3px;
}

</style>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">

    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    <script src="assets/js/purify.min.js"></script>



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

    <div id="bob-loadmore">
      <p id="loadmore" style="color: #black;cursor: pointer;text-align: center;">Load More</p>
    </div>

</div>

<script>

const urlParams = new URLSearchParams(window.location.search);
const limit = urlParams.has('postlimit') && !isNaN(urlParams.get('postlimit')) 
    ? Math.max(1, parseInt(urlParams.get('postlimit'), 10)) 
    : 35; 

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

function increasePostLimit() {
    limit += 15; 
    fetchPosts();
}

function fetchPosts() {
fetch('<?php echo $siteurl; ?>/apiv1/fetch_posts_api.php')
        .then(response => response.json())
        .then(data => {
            const postsContainer = document.getElementById('posts-container');

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

const writePost = document.createElement('div');
writePost.className = 'write-post';

const level1 = document.createElement('div');
level1.className = 'level-1';

const pfpWritePost = document.createElement('div');
pfpWritePost.className = 'pfp-write-post';
pfpWritePost.style.display = 'none';

const pfpImage = document.createElement('img');
pfpImage.src = `<?php echo htmlspecialchars($siteurl, ENT_QUOTES, 'UTF-8'); ?>/apiv1/fetch_pfp_api.php?name=<?php echo htmlspecialchars($_SESSION["username"], ENT_QUOTES, 'UTF-8'); ?>`;
pfpImage.alt = '';
pfpImage.className = 'round-image';

pfpWritePost.appendChild(pfpImage);

const textArea = document.createElement('textarea');
textArea.id = 'postTextArea';
textArea.placeholder = "Share what's new...";

const triangle = document.createElement('div');
triangle.id = 'triangle';
triangle.className = 'triangle';

level1.appendChild(pfpWritePost);
level1.appendChild(textArea);
level1.appendChild(triangle);

writePost.appendChild(level1);
postCreate.appendChild(writePost);

const fileDrop = document.createElement('div');
fileDrop.id = 'fileDrop';
fileDrop.className = 'file-drop';

postCreate.appendChild(fileDrop);

const level2 = document.createElement('div');
level2.className = 'level-2';

const attachPhotosRow = document.createElement('div');
attachPhotosRow.className = 'attach-photos-row';

const attachDiv = document.createElement('div');
attachDiv.className = 'attach';
attachDiv.textContent = 'Attach:';

const photoIcon1 = document.createElement('div');
photoIcon1.id = 'mymotherquestionmark';
photoIcon1.className = 'photo-icon';
const photoIconText1 = document.createElement('p');
photoIconText1.style.position = 'relative';
photoIconText1.style.top = '-7px';
photoIconText1.style.left = '15px';
photoIconText1.textContent = 'Photos';
photoIcon1.appendChild(photoIconText1);

const photoIcon2 = document.createElement('div');
photoIcon2.id = 'bobisbackbutfuckhim';
photoIcon2.className = 'photo-icon';
const photoIconText2 = document.createElement('p');
photoIconText2.style.position = 'relative';
photoIconText2.style.top = '-7px';
photoIconText2.style.left = '15px';
photoIconText2.textContent = 'Link';
photoIcon2.appendChild(photoIconText2);

const photoIcon3 = document.createElement('div');
photoIcon3.id = 'videosarebackbaby';
photoIcon3.className = 'photo-icon';
const photoIconText3 = document.createElement('p');
photoIconText3.style.position = 'relative';
photoIconText3.style.top = '-8px';
photoIconText3.style.left = '15px';
photoIconText3.textContent = 'Video';
photoIcon3.appendChild(photoIconText3);

attachPhotosRow.appendChild(attachDiv);
attachPhotosRow.appendChild(photoIcon1);
attachPhotosRow.appendChild(photoIcon2);
attachPhotosRow.appendChild(photoIcon3);

level2.appendChild(attachPhotosRow);

const level3 = document.createElement('div');
level3.className = 'level-3';
level3.style.display = 'none';

const addPhotos = document.createElement('div');
addPhotos.className = 'add-photos';
addPhotos.textContent = 'Add Photos:';

const fileUploadInput1 = document.createElement('input');
fileUploadInput1.type = 'file';
fileUploadInput1.id = 'fileUploadInput';
fileUploadInput1.accept = 'image/*';
fileUploadInput1.style.display = 'none';

const fileUploadInput2 = document.createElement('input');
fileUploadInput2.type = 'file';
fileUploadInput2.id = 'fileUploadInput';
fileUploadInput2.accept = 'image/*';
fileUploadInput2.style.display = 'none';

const uploadButton = document.createElement('button');
uploadButton.className = 'upload-button';
uploadButton.id = 'openFileDialog';
uploadButton.textContent = 'Upload from computer';

level3.appendChild(addPhotos);
level3.appendChild(fileUploadInput1);
level3.appendChild(fileUploadInput2);
level3.appendChild(uploadButton);

level2.appendChild(level3);

const addLink = document.createElement('div');
addLink.className = 'add-link';
addLink.style.display = 'none';

const addLinkParagraph = document.createElement('p');
addLinkParagraph.id = 'pthingy1';
addLinkParagraph.textContent = 'Add Link:';

const addLinkTextArea = document.createElement('textarea');
addLinkTextArea.className = 'add-link1';
addLinkTextArea.id = 'al1';
addLinkTextArea.style.height = '46px';
addLinkTextArea.style.width = '79%';
addLinkTextArea.style.marginLeft = '120px';
addLinkTextArea.style.marginTop = '8px';
addLinkTextArea.style.position = 'relative';
addLinkTextArea.style.top = '20px';
addLinkTextArea.style.overflow = 'hidden';
addLinkTextArea.style.border = '1px solid rgba(10, 10, 10, 0.1)';
addLinkTextArea.style.fontWeight = 'bold';
addLinkTextArea.style.fontSize = '14px';
addLinkTextArea.placeholder = 'Insert your link here, it must start with http/https or it wont send.';

addLink.appendChild(addLinkParagraph);
addLink.appendChild(addLinkTextArea);

const addVideo = document.createElement('div');
addVideo.className = 'add-video';
addVideo.style.display = 'none';

const addVideoParagraph = document.createElement('p');
addVideoParagraph.id = 'pthingy1';
addVideoParagraph.textContent = 'Add Video:';

const addVideoTextArea = document.createElement('textarea');
addVideoTextArea.className = 'add-link1';
addVideoTextArea.id = 'al2';
addVideoTextArea.style.height = '46px';
addVideoTextArea.style.width = '79%';
addVideoTextArea.style.marginLeft = '120px';
addVideoTextArea.style.marginTop = '8px';
addVideoTextArea.style.position = 'relative';
addVideoTextArea.style.top = '20px';
addVideoTextArea.style.overflow = 'hidden';
addVideoTextArea.style.border = '1px solid rgba(10, 10, 10, 0.1)';
addVideoTextArea.style.fontSize = '14px';
addVideoTextArea.placeholder = 'Insert your youtube video here, it must be a standerd youtube url or it wont send.';

addVideo.appendChild(addVideoParagraph);
addVideo.appendChild(addVideoTextArea);

level2.appendChild(addLink);
level2.appendChild(addVideo);

postCreate.appendChild(level2);

const postCreateIcons = document.createElement('div');
postCreateIcons.className = 'post-create-icons';

const iconstuff1 = document.createElement('div');
iconstuff1.className = 'iconstuff';

const imageWrite = document.createElement('div');
imageWrite.className = 'image-write';

const iconText1 = document.createElement('span');
iconText1.style.color = 'black';
iconText1.style.fontWeight = 'bold';
iconText1.textContent = 'Text';

iconstuff1.appendChild(imageWrite);
iconstuff1.appendChild(document.createElement('br'));
iconstuff1.appendChild(document.createElement('br'));
iconstuff1.appendChild(iconText1);

const iconstuff2 = document.createElement('div');
iconstuff2.className = 'iconstuff';

const imagePhoto = document.createElement('div');
imagePhoto.className = 'image-photo';

const iconText2 = document.createElement('span');
iconText2.textContent = 'Photos';

iconstuff2.appendChild(imagePhoto);
iconstuff2.appendChild(document.createElement('br'));
iconstuff2.appendChild(document.createElement('br'));
iconstuff2.appendChild(iconText2);

postCreateIcons.appendChild(iconstuff1);
postCreateIcons.appendChild(iconstuff2);

postCreate.appendChild(postCreateIcons);

const level4 = document.createElement('div');
level4.className = 'level-4';
level4.style.background = '#fff';

const shareButton = document.createElement('button');
shareButton.className = 'share-button';
shareButton.style.background = '#55a644';
shareButton.textContent = 'Share';

const cancelButton = document.createElement('button');
cancelButton.className = 'cancel-button';
cancelButton.id = 'cancelButton';
cancelButton.style.background = '#fbfbfb';
cancelButton.style.color = 'black';
cancelButton.textContent = 'Cancel';

level4.appendChild(shareButton);
level4.appendChild(cancelButton);

postCreate.appendChild(level4);

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

            $writePostDiv.show();
            $level4.show();
        });

        $('.triangle').css({
            transform: 'rotate(45deg)',
            width: '28px',
            height: '28px',
            zIndex: '1',
            left: '144px',
            top: '23px',
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

            $writePostDiv.show();
            $level4.show();
        });

        $('.triangle').css({
            transform: 'rotate(45deg)',
            width: '28px',
            height: '28px',
            zIndex: '1',
            left: '144px',
            top: '23px',
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

            $writePostDiv.show();
            $level4.show();
        });

        $('#postTextArea').css({
            width: '75%',
            left: '22%',
            position: 'relative',
            border: '1px solid rgba(10, 10, 10, 0.1)',
            zIndex: '2',
        });

        $('.triangle').css({
            transform: 'rotate(45deg)',
            width: '28px',
            height: '28px',
            zIndex: '1',
            left: '144px',
            top: '23px',
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
success: function(response) {
smoothReload(500);

if (response.status === 'success') {
    console.log(response.message);
} else {

    console.log(response.message);
}
},
error: function(error) {

console.log('Error:', error);
}
});
});
});

const apiEndpoint = '<?php echo $siteurl; ?>/apiv1/fetch_comments.php?id=';

let currentColumnIndex = 0;

const loadMoreText = $('#load-more');
var isExperimentalLoading = urlParams.has('experimental_loading');

$(document).on('click', '#loadmore', function() {
    increasePostLimit();
});

for (let i = 0; i < Math.min(limit, data.length); i++) {
    const post = data[i];

    const postElement = document.createElement('div');
    postElement.className = 'post';
    const formattedTime = formatTime(post.created_at);

    const plusOneUsernamesString = post.plus_one_usernames || '';
    const isLikedByCurrentUser = plusOneUsernamesString.includes('<?php echo $_SESSION["username"];?>');

    const postMain = document.createElement('div');
    postMain.className = 'post-main';

    const hackyFix = document.createElement('div');
    hackyFix.className = 'hacky-fix';

    const postFilePicture = document.createElement('img');
    postFilePicture.className = 'post-file-picture';
    postFilePicture.src = `<?php echo htmlspecialchars($siteurl, ENT_QUOTES, 'UTF-8'); ?>/apiv1/fetch_pfp_api.php?name=${encodeURIComponent(post.username)}`;

    const aaaa = document.createElement('div');
    aaaa.className = 'aaaaaa';

    const postTop = document.createElement('div');
    postTop.className = 'post-top';

    const usernameLink = document.createElement('a');
    usernameLink.href = `<?php echo htmlspecialchars($siteurl, ENT_QUOTES, 'UTF-8'); ?>/profile.php?profile=${encodeURIComponent(post.username)}`;

    const username = document.createElement('p');
    username.className = 'username';
    username.textContent = post.username;

    usernameLink.appendChild(username);

    const clickableCircle = document.createElement('span');
    clickableCircle.className = 'clickable-circle';

    const unicodeCharacter = document.createTextNode('˅');
    clickableCircle.appendChild(unicodeCharacter);

    postTop.appendChild(usernameLink);
    postTop.appendChild(clickableCircle);

    const dropdownMenuDel = document.createElement('div');
    dropdownMenuDel.className = 'dropdown-menu-del';
    dropdownMenuDel.style.display = 'none';

    const deletePostLink = document.createElement('a');
    deletePostLink.href = '#';
    deletePostLink.className = 'delete-post-link';
    deletePostLink.textContent = 'Delete post';

    dropdownMenuDel.appendChild(deletePostLink);

    postTop.appendChild(dropdownMenuDel);

    const postMeta = document.createElement('div');
    postMeta.className = 'post-meta';

    const sharingPublicly = document.createElement('span');
    sharingPublicly.textContent = 'Sharing Publicly ';

    const viewPostLink = document.createElement('a');
    viewPostLink.href = `view_post.php?id=${encodeURIComponent(post.id)}`;
    viewPostLink.style.color = 'inherit';
    viewPostLink.style.textDecoration = 'none';

    const uploadTime = document.createElement('span');
    uploadTime.className = 'upload-time';
    uploadTime.textContent = `- ${formattedTime}`;

    viewPostLink.appendChild(uploadTime);

    postMeta.appendChild(sharingPublicly);
    postMeta.appendChild(viewPostLink);

    aaaa.appendChild(postTop);
    aaaa.appendChild(postMeta);

    hackyFix.appendChild(postFilePicture);
    hackyFix.appendChild(aaaa);

    postMain.appendChild(hackyFix);

    const postContentContainer = document.createElement('div');
    postContentContainer.className = 'post-content-container';

    const postContent = document.createElement('p');
    postContent.className = 'post-content';
    postContent.textContent = post.content;

    const postImage = document.createElement('img');
    postImage.className = 'post-image';
    postImage.src = post.image_url;
    postImage.alt = '';

    const linkPreview = document.createElement('div');
    linkPreview.className = 'link-preview';

    const youtubeEmbed = document.createElement('div');
    youtubeEmbed.className = 'youtube-emded';

    postContentContainer.appendChild(postContent);
    postContentContainer.appendChild(postImage);
    postContentContainer.appendChild(linkPreview);
    postContentContainer.appendChild(youtubeEmbed);

    postMain.appendChild(postContentContainer);

    postElement.appendChild(postMain);

    columns[0].appendChild(postElement);

    const sessionUsername = '<?php echo $_SESSION["username"]; ?>';
    var isMod = <?php echo json_encode($isMod); ?>;
    
    console.log(post.username);

    $('.dropdown-menu-del').hide();

    if (post.username !== sessionUsername && !isMod) {
            $(postElement).find('.clickable-circle').hide();
    }

    $(document).on('click', '.delete-post-link', function(event) {
    event.preventDefault();

    var $post = $(this).closest('.post');
    var postId = $post.data('post-id');

    $.ajax({
        url: '<?php echo $siteurl; ?>/apiv1-internal/delete_post.php?id=' + postId, 
        type: 'DELETE',
        success: function(response) {
            smoothReload(500);
        },
        error: function() {
            alert('An error occurred while trying to delete the post.');
        }
        });
    });

    $(document).on('click', '.clickable-circle', function(event) {
        $('.dropdown-menu-del').not($(this).siblings('.dropdown-menu-del')).hide();
        $(this).siblings('.dropdown-menu-del').show();
    });

    $(document).on('dblclick', '.clickable-circle', function(event) {
        $('.dropdown-menu-del').not($(this).siblings('.dropdown-menu-del')).hide();
        $(this).siblings('.dropdown-menu-del').hide();
    });

        

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
                const linkPreviewContainer = $('<div>', {
                    class: 'link-preview'
                });
                const faviconContainer = $('<div>', {
                    class: 'favicon-container'
                });
                const faviconImg = $('<img>', {
                    src: metadata.image,
                    alt: 'Favicon',
                    class: 'favicon-img'
                });
                faviconContainer.append(faviconImg);
                const contentContainer = $('<div>', {
                    class: 'content-container'
                });
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

    hideShowCommentsLink.addEventListener('click', function(e) {
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
        success: function(commentsData) {
            if (commentsData.status === 'success') {

                $.each(commentsData.comments, function(index, comment) {

                    const commentElement = $('<div>', { class: 'comment' });

                    const hackyFix = $('<div>', { class: 'hacky-fix' });

                    const commentPicture = $('<img>', {
                        class: 'comment-picture',
                        src: `<?php echo htmlspecialchars($siteurl, ENT_QUOTES, 'UTF-8'); ?>/apiv1/fetch_pfp_api.php?name=${encodeURIComponent(comment.username)}`
                    });

                    const agony = $('<div>', { class: 'agony' });

                    const innerHackyFix = $('<div>', { class: 'hacky-fix' });

                    const usernameLink = $('<a>', {
                        href: `<?php echo htmlspecialchars($siteurl, ENT_QUOTES, 'UTF-8'); ?>/profile.php?profile=${encodeURIComponent(comment.username)}`
                    }).append($('<p>', { class: 'username', text: comment.username }));

                    const commentTime = $('<p>', { class: 'time', text: comment.comment_time });

                    innerHackyFix.append(usernameLink, commentTime);

                    const commentContent = $('<p>', { class: 'comment-content', text: comment.comment_content });

                    agony.append(innerHackyFix, commentContent);

                    hackyFix.append(commentPicture, agony);

                    commentElement.append(hackyFix);

                    $(commentArea).append(commentElement);

                commentArea.appendChild(commentElement);

                });

            } else {

                console.log('No comments found for the post with ID ' + post.id);
            }
        },
        error: function(error) {

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
                    position: 'relative',
                    paddingTop: '3px'
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

                    $('#georgewallace').css('color', 'white');

                    $.ajax({
                        url: '<?php echo $siteurl; ?>/apiv1/add_plus_one.php',
                        type: 'POST',
                        data: {
                            add_plus_one: true,
                            id: postID,
                            username: username
                        },
                        success: function(response) {
                            console.log(response);
                            smoothReload();
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

                    commentInput.css('padding-top', '3px')

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
                            smoothReload(500);

                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                            smoothReload(250);
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

$(document).on('click', function(event) {

    if (!$(event.target).closest('#fileDrop').length && !$(event.target).is($writePostPhotoRealIcon) && !$(event.target).is($uploadButton)) {
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

$('#cancelButton').click(function() {
    smoothReload(500);
});

const commentMain = $('.comment-main');

fetchPosts();

function smoothReload(delay) {
    $("body").fadeOut(delay, function() {
        history.replaceState({}, document.title, window.location.pathname);
        location.reload();
    });
}

</script>

<script src="assets/js/sidebar.js"></script>
<script src="assets/js/funshit.js"></script>
<script src="assets/js/fixes.js"></script>

</body>
</html>