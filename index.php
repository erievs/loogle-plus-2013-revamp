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
  display:none;
} 

.comment-input {
    padding-top: 3px;
}

textarea {
    padding-top: 3px;
}

.smooth-transition {
  position: relative; 
}

.content {
    background-size: contain;
    background-position: center;
    transition: background-image 1s ease-in-out; 
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

let postCreateMoved = false; 
let selectedFile = null;

const urlParams = new URLSearchParams(window.location.search);
var limit = urlParams.has('postlimit') && !isNaN(urlParams.get('postlimit')) 
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

function decodeHTMLEntities(text) {
    var tempElement = $('<textarea>').html(text);
    return tempElement.val();
}

function formatTime(timestamp) {
    const date = new Date(timestamp);
    const options = { month: 'long', day: 'numeric', year: 'numeric' };
    return date.toLocaleString('en-US', options);
}

function increasePostLimit() {
    limit += 10; 
    fetchPosts();
}

let currentPage = 1;

window.addEventListener('scroll', onScroll);
function onScroll() {
    const columns = document.querySelectorAll('.column'); 
    let nearBottom = false;

    columns.forEach(column => {
        const columnBottom = column.getBoundingClientRect().bottom;
        const viewportBottom = window.innerHeight + window.scrollY;

        console.log('Column Bottom:', columnBottom);
        console.log('Viewport Bottom:', viewportBottom);

        if (columnBottom <= viewportBottom + 200) { 
            nearBottom = true;
        }
    });

    console.log('Near Bottom:', nearBottom);

    if (nearBottom) {
        console.log('Current Page:', currentPage);
        console.log('Triggering fetch for page:', currentPage + 1);

        currentPage++;
        fetchPosts(currentPage);
    }
}

function fetchPosts(currentPage) {

const apiUrl = `<?php echo $siteurl; ?>/apiv1/fetch_posts_api.php?page=${currentPage}`;

console.log('Fetching URL:', apiUrl);

fetch(apiUrl)
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

const existingColumns = postsContainer.getElementsByClassName('column');
const currentColumnCount = existingColumns.length;

if (currentColumnCount < numColumns) {
    for (let i = currentColumnCount; i < numColumns; i++) {
        const column = document.createElement('div');
        column.className = 'column';
        postsContainer.appendChild(column);
    }
}

const columns = [];
for (let i = 0; i < numColumns; i++) {
    columns.push(existingColumns[i]);
}

let existingPostCreate = postsContainer.querySelector('.post-create');

if (!existingPostCreate) {
    const postCreateHTML = `
        <div class="post-create">
            <div class="write-post">
                <div class="level-1">
                    <div class="pfp-write-post" style="display: none;">
                        <img src="<?php echo htmlspecialchars($siteurl, ENT_QUOTES, 'UTF-8'); ?>/apiv1/fetch_pfp_api.php?name=<?php echo htmlspecialchars($_SESSION["username"], ENT_QUOTES, 'UTF-8'); ?>" alt="" class="round-image">
                    </div>
                    <textarea class="postTextAreaClass" id="postTextArea" placeholder="Share what's new..."></textarea>
                    <div id="triangle" class="triangle"></div>
                </div>
            </div>
            <div id="fileDrop" class="file-drop"></div>
            <div class="level-2">
                <div class="attach-photos-row">
                    <div class="attach">Attach:</div>
                    <div id="mymotherquestionmark" class="photo-icon">
                        <p style="position: relative; top: -7px; left: 15px;">Photos</p>
                    </div>
                    <div id="bobisbackbutfuckhim" class="photo-icon">
                        <p style="position: relative; top: -7px; left: 15px;">Link</p>
                    </div>
                    <div id="videosarebackbaby" class="photo-icon">
                        <p style="position: relative; top: -8px; left: 15px;">Video</p>
                    </div>
                </div>
                <div class="level-3" style="display: none;">
                    <div class="add-photos">Add Photos:</div>
                    <input type="file" id="fileUploadInput1" accept="image/*" style="display: none;">
                    <input type="file" id="fileUploadInput2" accept="image/*" style="display: none;">
                    <button class="upload-button" id="openFileDialog">Upload from computer</button>
                </div>
                <div class="add-link" style="display: none;">
                    <p id="pthingy1">Add Link:</p>
                    <textarea class="add-link1" id="al1" style="height: 46px; width: 79%; margin-left: 120px; margin-top: 8px; position: relative; top: 20px; overflow: hidden; border: 1px solid rgba(10, 10, 10, 0.1); font-weight: bold; font-size: 14px;" placeholder="Insert your link here, it must start with http/https or it wont send."></textarea>
                </div>
                <div class="add-video" style="display: none;">
                    <p id="pthingy1">Add Video:</p>
                    <textarea class="add-link1" id="al2" style="height: 46px; width: 79%; margin-left: 120px; margin-top: 8px; position: relative; top: 20px; overflow: hidden; border: 1px solid rgba(10, 10, 10, 0.1); font-size: 14px;" placeholder="Insert your youtube video here, it must be a standard youtube url or it wont send."></textarea>
                </div>
            </div>
            <div class="post-create-icons">
                <div class="iconstuff">
                    <div class="image-write"></div>
                    <br><br>
                    <span style="color: black; font-weight: bold;">Text</span>
                </div>
                <div class="iconstuff">
                    <div class="image-photo"></div>
                    <br><br>
                    <span>Photos</span>
                </div>
            </div>
            <div class="level-4" style="background: #fff;">
                <button id="shareButton" class="share-button" style="background: #55a644;">Share</button>
                <button class="cancel-button" id="cancelButton" style="background: #fbfbfb; color: black;">Cancel</button>
            </div>
        </div>
    `;

    let postCreate = document.createElement('div');
    postCreate.id = 'bobissomeonesuncle';

    postCreate.innerHTML = postCreateHTML;

    columns[0].appendChild(postCreate);
}

$(document).ready(function () {

function getQueryParameter(name) {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.has(name);
}

function getQueryParameter(name) {
const urlParams = new URLSearchParams(window.location.search);
return urlParams.has(name);
}

$('#openFileDialog').click(function () {
    const fileInput = $('#fileUploadInput1')[0]; 

    fileInput.click(); 

    fileInput.onchange = function () {
        selectedFile = fileInput.files[0]; 
        if (selectedFile) {
            console.log('Selected file:', selectedFile.name);
        } else {
            console.log('No file selected');
        }
    };
});


function addPostCreateToBobissomeonesuncle() {
    let bobissomeonesuncle = document.getElementById('bobissomeonesuncle');
    let writePostExpanded = document.querySelector('.write-post-expanded');

    const $writePostDiv = $('.write-post-expanded'); 
    $writePostDiv.hide();

    if (!bobissomeonesuncle) return;

    let existingPostCreate = document.querySelector('.post-create');
    if (existingPostCreate) {
        existingPostCreate.remove();
    }

    let postCreate = document.createElement('div');
    postCreate.className = 'post-create';

    const postCreateHTML = `
        <div class="write-post">
            <div class="level-1">
                <div class="pfp-write-post" style="display: none;">
                    <img src="<?php echo htmlspecialchars($siteurl, ENT_QUOTES, 'UTF-8'); ?>/apiv1/fetch_pfp_api.php?name=<?php echo htmlspecialchars($_SESSION["username"], ENT_QUOTES, 'UTF-8'); ?>" alt="" class="round-image">
                </div>
                <textarea id="postTextArea" placeholder="Share what's new..."></textarea>
                <div id="triangle" class="triangle"></div>
            </div>
        </div>
        <div id="fileDrop" class="file-drop"></div>
        <div class="level-2">
            <div class="attach-photos-row">
                <div class="attach">Attach:</div>
                <div id="mymotherquestionmark" class="photo-icon">
                    <p style="position: relative; top: -7px; left: 15px;">Photos</p>
                </div>
                <div id="bobisbackbutfuckhim" class="photo-icon">
                    <p style="position: relative; top: -7px; left: 15px;">Link</p>
                </div>
                <div id="videosarebackbaby" class="photo-icon">
                    <p style="position: relative; top: -8px; left: 15px;">Video</p>
                </div>
            </div>
            <div class="level-3" style="display: none;">
                <div class="add-photos">Add Photos:</div>
                <input type="file" id="fileUploadInput1" accept="image/*" style="display: none;">
                <input type="file" id="fileUploadInput2" accept="image/*" style="display: none;">
                <button class="upload-button" id="openFileDialog">Upload from computer</button>
            </div>
            <div class="add-link" style="display: none;">
                <p id="pthingy1">Add Link:</p>
                <textarea class="add-link1" id="al1" style="height: 46px; width: 79%; margin-left: 120px; margin-top: 8px; position: relative; top: 20px; overflow: hidden; border: 1px solid rgba(10, 10, 10, 0.1); font-weight: bold; font-size: 14px;" placeholder="Insert your link here, it must start with http/https or it wont send."></textarea>
            </div>
            <div class="add-video" style="display: none;">
                <p id="pthingy1">Add Video:</p>
                <textarea class="add-link1" id="al2" style="height: 46px; width: 79%; margin-left: 120px; margin-top: 8px; position: relative; top: 20px; overflow: hidden; border: 1px solid rgba(10, 10, 10, 0.1); font-size: 14px;" placeholder="Insert your youtube video here, it must be a standard youtube url or it wont send."></textarea>
            </div>
        </div>
        <div class="post-create-icons">
            <div class="iconstuff">
                <div class="image-write"></div>
                <br><br>
                <span style="color: black; font-weight: bold;">Text</span>
            </div>
            <div class="iconstuff">
                <div class="image-photo"></div>
                <br><br>
                <span>Photos</span>
            </div>
        </div>
        <div class="level-4" style="background: #fff;">
            <button class="share-button" style="background: #55a644;">Share</button>
            <button class="cancel-button" id="cancelButton" style="background: #fbfbfb; color: black;">Cancel</button>
        </div>
    `;

    postCreate.innerHTML = postCreateHTML;

    bobissomeonesuncle.appendChild(postCreate);

    $('#cancelButton').on('click', function() {
        postCreateMoved = false;
        addPostCreateToBobissomeonesuncle(); 
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

        console.log('Please enter text, select an image, add a link, or upload a video before sharing.');

        if (!postContent && $('#fileUploadInput1')[0].files.length === 0 && !postLink && !postVideo) {
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

        if (selectedFile) {
            formData.append('postImage', selectedFile); 
        }

        $.ajax({
            type: 'POST',
            url: '<?php echo $siteurl; ?>/apiv1-internal/submit_post_api.php',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function (response) {

                addPostCreateToBobissomeonesuncle();

                if (response.status === 'success') {
                    console.log('Post shared successfully:', response.message);

                    selectedFile = null;

                    $("#posts-container").fadeOut(500, function() {
                        $(this).load(location.href + " #posts-container", function() {
                            fetchPosts(currentPage);
                            $(this).fadeIn(500);
                        });
                    });


                } else {
                    console.log('Failed to share post:', response.message);
                    
                    selectedFile = null;

                    $("#posts-container").fadeOut(500, function() {
                        $(this).load(location.href + " #posts-container", function() {
                            fetchPosts(currentPage);
                            $(this).fadeIn(500);
                        });
                    });


                }
            },
            error: function (error) {
                console.log('Error submitting post:', error);
            }
        });
    });


    postCreateMoved = false;
    console.log('Post-create has been re-added:', postCreateMoved);
}

$('.share-button').click(function () {
        const postContent = $('#postTextArea').val();
        const postLink = $('#al1').val();
        const postVideo = $('#al2').val();
        const username = '<?php echo isset($_SESSION["username"]) ? $_SESSION["username"] : ""; ?>';

        console.log('Please enter text, select an image, add a link, or upload a video before sharing.');

        if (!postContent && $('#fileUploadInput1')[0].files.length === 0 && !postLink && !postVideo) {
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

        if (selectedFile) {
            formData.append('postImage', selectedFile); 
        }

        $.ajax({
            type: 'POST',
            url: '<?php echo $siteurl; ?>/apiv1-internal/submit_post_api.php',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function (response) {
    
                fetchPosts(currentPage);
                addPostCreateToBobissomeonesuncle();

                if (response.status === 'success') {
                    console.log('Post shared successfully:', response.message);

                    selectedFile = null;

                    $("#posts-container").fadeOut(500, function() {
                        $(this).load(location.href + " #posts-container", function() {
                            fetchPosts(currentPage);
                            $(this).fadeIn(500);
                        });
                    });

                } else {
                    console.log('Failed to share post:', response.message);

                    selectedFile = null;

                    $("#posts-container").fadeOut(500, function() {
                        $(this).load(location.href + " #posts-container", function() {
                            fetchPosts(currentPage);
                            $(this).fadeIn(500);
                        });
                    });


                }
            },
            error: function (error) {
                console.log('Error submitting post:', error);
            }
    });
});

$(document).on('click', '#postTextArea', function () {
    if (!postCreateMoved) {
        const $postCreate = $('.post-create'); 
        const $writePostDiv = $('.write-post-expanded');
        const $writePostImage = $('.pfp-write-post');
        const $writePostLevel2 = $('.level-2');
        const $writePostLevel2p5 = $('.level-2.5');
        const $writePostLevel3 = $('.level-3');
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
        const $box = $('#fileDrop');
        const $attachRow = $('.attach-photos-row');

        const destination = $writePostDiv.position();

        $writePostDiv.show();

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

        // Apply the CSS to postTextArea
        $('#postTextArea').css({
            width: '75%',
            left: '22%',
            position: 'relative',
            border: '1px solid rgba(10, 10, 10, 0.1)',
            zIndex: '2',
        });

        // Apply CSS to triangle
        $('.triangle').css({
            transform: 'rotate(45deg)',
            width: '28px',
            height: '28px',
            zIndex: '1',
            left: '144px',
            top: '23px',
        });

        // Adjust level 4 and other elements
        $level4.css({
            top: '90px'
        });

        $writePostLevel3.css({
            top: '20px'
        })

        $writePostImage.show();
        $writePostLevel2.show();
        $level4.show();
        $box.hide();

        // Link Icon click - Show link input
        $writePostLinkIcon.one('click', function () {
            $attachRow.hide();
            $addLinktext.show();
            $postCreate.css({ height: '350px' });
            $level4.css({ top: '80px' });
        });

        // Video Icon click - Show video input
        $writePostVideoIcon.one('click', function () {
            $attachRow.hide();
            $addVideotext.show();
            $postCreate.css({ height: '350px' });
            $level4.css({ top: '118px' });
        });

        // Photo Icon click - Show photo upload section
        $writePostPhotoRealIcon.one('click', function () {
            $("#fileDrop").toggle(function () {
                if ($(this).is(":visible")) {
                    $postCreate.css({ height: '350px' });
                    $addPhotostext.show();
                    $writePostLevel3.show();
                    $uploadButton.show();
                    $attachRow.hide();
                    $level4.show();
                    $box.hide();
                    $photo.css({ display: 'none' });
                    $attach.css({ display: 'none' });
                    $level4.css({ top: '120px' });
                } else {
                    $addPhotostext.hide();
                    $writePostLevel2p5.show();
                    $writePostLevel2.show();
                    $writePostLevel3.hide();
                    $level4.css({ top: '90px' });
                }
            });
        });

        // Allow triggering this functionality only once until reset
        postCreateMoved = true;
    }
});



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
            i
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

$('#cancelButton').click(function () {
    console.log('vov is unce');
    addPostCreateToBobissomeonesuncle();
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



$('#shareButton').click(function () {


    });
});

const apiEndpoint = '<?php echo $siteurl; ?>/apiv1/fetch_comments.php?id=';

let currentColumnIndex = 0;

const loadMoreText = $('#load-more');
var isExperimentalLoading = urlParams.has('experimental_loading');

$(document).on('click', '#loadmore', function() {
    increasePostLimit();
});

for (let i = 0; i < Math.min(data.length); i++) {

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

    const decodedContent = decodeHTMLEntities(post.content);
    const postContent = document.createElement('p');
    postContent.className = 'post-content';
    postContent.textContent = decodedContent;


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
            $post.remove();
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

                    const decodedContent = decodeHTMLEntities(comment.comment_content);
                    const commentContent = $('<p>', { class: 'comment-content' }).text(decodedContent);


                    agony.append(innerHackyFix, commentContent);

                    hackyFix.append(commentPicture, agony);

                    commentElement.append(hackyFix);

                    $(commentArea).append(commentElement);

              
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

                    var $closestPlusOneIcon = $(this).closest('.plus-one-icon');
                    var $closestGeorgeWallace = $closestPlusOneIcon.find('#georgewallace');
                    var currentValue = parseInt($closestGeorgeWallace.text().replace('+', '')) || 0;

                    $.ajax({
                        url: '<?php echo $siteurl; ?>/apiv1/add_plus_one.php',
                        type: 'POST',
                        data: {
                            add_plus_one: true,
                            id: postID,
                            username: username
                        },
                        success: function(response) {

                            var responseData = JSON.parse(response);

                            if (responseData.action === 'added') {
                                console.log("Plus one added.");
                                $closestGeorgeWallace.text(`+${currentValue + 1}`);
                                $closestPlusOneIcon.css('color', '#ffff'); 
                                $closestPlusOneIcon.css('background-color', '#cc4331'); 
                                $closestGeorgeWallace.css('color', '#ffff'); 
                            }  
                            
                            if (responseData.action === 'subtracted') {
                                console.log("Plus one subtracted.");
                                $closestGeorgeWallace.text(`+${currentValue - 1}`);
                                $closestPlusOneIcon.css('background-color', 'white'); 
                                $closestPlusOneIcon.css('color', '#333'); 
                                $closestGeorgeWallace.css('color', '#333'); 
                                
                            }
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

                const buttonContainer = $('<div style="margin-right: 250px;">');

                const submitButton = $('<button>').text('Post comment').addClass('submit-button').css('display', 'none');

                const cancelButton = $('<button>').text('Cancel').addClass('cancel').css('display', 'none');

                buttonContainer.append(submitButton, cancelButton);

                commentInputContainer.append(buttonContainer);

                $(this).after(commentInputContainer);

                commentInput.on('click', function() {
                    
                submitButton.css('display', 'inline-block');
                cancelButton.css('display', 'inline-block');

                $(this).closest('.comment-input-container').find('.plus-one-icon').hide();

                commentInput.attr('placeholder', '');

                commentInput.css({
                    'height': '60px',
                    'width': '440px',
                    'text-indent': '1ch',
                    'background': '#fff',
                    'border': '1px solid #ccc',
                    'padding': '0px',
                    'resize': 'none',
                    'overflowY': 'auto',
                    'padding-top': '3px',
                    'left': '23px'
                });

                commentInputContainer.css({
                    'background': '#f6f6f6',
                    'height': '125px',
                    'position': 'relative'
                });

                let newElement = $('<img id="khamlaharis">')
                .attr('src', '<?php echo htmlspecialchars($siteurl, ENT_QUOTES, 'UTF-8'); ?>/apiv1/fetch_pfp_api.php?name=<?php echo htmlspecialchars($_SESSION["username"], ENT_QUOTES, 'UTF-8'); ?>')
                .css({
                    'width': '25px',
                    'height': '25px',
                    'position': 'absolute',
                    'top': '17px',
                    'left': '18px',
                    'border-radius': '5%'
               });

                commentInputContainer.prepend(newElement);
            });

            var $closestCommentMain = $(this).closest('.comment-main');

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

                            var commentContent = response.commentContent;
                            var postID = response.postID;
                            var username = response.username;

                            var newComment = $('<div>', { class: 'comment' }).append(
                                $('<div>', { class: 'hacky-fix' }).append(
                                    $('<img>', {
                                        class: 'comment-picture',
                                        src: `<?php echo $siteurl; ?>/apiv1/fetch_pfp_api.php?name=${encodeURIComponent(username)}`
                                    }),
                                    $('<div>', { class: 'agony' }).append(
                                        $('<div>', { class: 'hacky-fix' }).append(
                                            $('<a>', {
                                                href: `<?php echo $siteurl; ?>/profile.php?profile=${encodeURIComponent(username)}`
                                            }).append($('<p>', { class: 'username', text:  username })),
                                            $('<p>', { class: 'time', text: new Date().toISOString().slice(0, 19).replace('T', ' ') }) 
                                        ),
                                        $('<p>', { class: 'comment-content', text: commentContent })
                                    )
                                )
                            );

                            $closestCommentMain.append(newComment);

                            function scrollToBottom(element, duration = 400) {
                                $(element).animate({
                                    scrollTop: $(element)[0].scrollHeight
                                }, duration);
                            }

                            scrollToBottom($closestCommentMain);

                            submitButton.css('display', 'none');
                            cancelButton.css('display', 'none');
                            

                            commentInputContainer.css('background-color', '#fff');
                            $('.plus-one-icon').show();
                            $('#khamlaharis').hide();

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

                            commentInput.attr('placeholder', 'Add a comment..');

                            commentInput.val('');

                            commentInput.trigger('blur');

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
                    $('#khamlaharis').hide();

                    commentInput.css({
                        height: '30px',
                        width: '275px',
                        left: '17%'
                    });


                    commentInput.val('');

                    commentInputContainer.css('height', '50px');

                    commentInput.css({
                        background: '#fff',
                        border: '1px solid #ccc'

                    });

                    commentInput.attr('placeholder', 'Add a comment..');

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

const commentMain = $('.comment-main');

fetchPosts(currentPage);

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