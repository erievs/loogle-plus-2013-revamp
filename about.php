<?php
session_start();

if (!isset($_SESSION["username"])) {
    header("Location: ../user/login.php");
    exit();
}

include("important/db.php");

$profileget = htmlspecialchars($_GET['profile']);

$username = $_SESSION["username"];

$icon = "about";

?>

<?php
if(isset($_GET['trump'])) {
    echo '<link rel="stylesheet" href="assets/css/trump.css">';
}
?>



<!DOCTYPE html>
<html lang="en">
<head>

    <title><?php echo $profileget?>'s Profile</title>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <link rel="icon" 
      type="image/png" 
      href="assets/important-images/fav.png" />

    <link rel="stylesheet" href="assets/css/2013isamess.css">
    <link rel="stylesheet" href="assets/css/2013indexres.css">
    <link rel="stylesheet" href="assets/css/2013profile.css">
    <link rel="stylesheet" href="assets/css/2013notes.css">
	<link rel="stylesheet" href="assets/css/univesalcoolstuff.css">
    <link rel="stylesheet" href="assets/css/writespost.css">
    <link rel="stylesheet" href="assets/css/2013about.css">
</head>
<body>

<?php require_once("inc/topstuffs.php")?>

<!-- Must be linked bellow, since it loads the style sheet in topstuff. -->

<link rel="stylesheet" href="assets/css/headerfix.css">
<link rel="stylesheet" href="assets/css/2013profile_headerfix.css">

<div class="banner">
<div class="bg-grad" style="background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('<?php echo $siteurl; ?>/apiv1/fetch_banner_api.php?name=<?php echo $profileget ?>'); height: 20em; background-size: cover;">
    </div>
    <div style="background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('<?php echo $siteurl; ?>/apiv1/fetch_banner_api.php?name=<?php echo $profileget ?>'); height: 20em; background-size: cover;">
</div>
        <div class="profilestuff">
        <?php if (isset($_SESSION["username"]) && $_SESSION["username"] === $profileget): ?>
    <div class="pfp-container">
        <img alt="<?php echo $profileget ?>" src="<?php echo $siteurl; ?>/apiv1/fetch_pfp_api.php?name=<?php echo $profileget ?>" class="pfp-picture">
        <div class="change-photo-button">
            <span class="sb-card-body-arrow" id="custom-profile-arrow"></span>
            <div id="cam" class="cricle"> </div>
            <button id="whatsmyteacheryappingtoday" style="">Change profile photo</button>
        </div>
    </div>
<?php else: ?>
    <img alt="<?php echo $profileget ?>" src="<?php echo $siteurl; ?>/apiv1/fetch_pfp_api.php?name=<?php echo $profileget ?>" class="pfp-picture">
<?php endif; ?>


            <h2 class="profile-username"><?php echo $profileget ?></h2>
            <?php
            session_start(); 
            if (isset($_SESSION["username"]) && $_SESSION["username"] === $profileget) {
                echo '<button id="open-cool-cover" class="fuckjohnhinckleyjunior" type="submit">
                    <!-- sorry winter -->
                <p style="margin-top: 3px; color: #cfd1d3;">Change cover</p>
                </button>';
                }
                ?>

        </div>
    </div>
</div>

<div id="uploadbanner-banner-banner" class="modal">
  <div class="modal-content">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" id="boi1">&times;</span></button>
    <div class="row">
      <div class="col-xs-3">
        <div class="modal-side">
          <span id="pleasefuckingcheckinwithmebefordoinganythingmorethancss"></span>
          <ul class="top-submenus">
            <b id="select-text">Select cover banner</b>
            <br><br> <!-- Hacky fix  -->
            <li class="highlighted"><a href="#">Upload</a></li>
            <li><a href="#">Your Photos</a></li>
            <li><a href="#">Photos of you</a></li>
            <li><a href="#">Web camera</a></li>
          </ul>
     
        </div>
      </div>
      <div class="col-xs-9">
        <div class="upload-area-banner" id="banner-cool">
          <p class="inside-job" id="bwc">Drag a photo here</p> 
          <p class="inside-job" id="lwc">Or if you prefer</p> 
          <button class="ifyouwalkandiwasgone" id="banner-upload-inside-cool" id="banner-upload">Select a photo from your computer</button>
        </div>
      </div>
    </div>
    <div class="row">
      <div style="margin-left: 460px;" class="modal-bottom">
        <button class="ifyouwalkandiwasgone" id="banner-upload">Set as banner</button>
        <button style="margin-left: -105px;" class="close-banner" id="donotaskwhatwedidtojapaninthe40s">Cancel</button>
      </div>
    </div>
  </div>
</div>


<div id="uploadbanner-pfp" class="modal">
  <div class="modal-content">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" id="boi1">&times;</span></button>
    <div class="row">
      <div class="col-xs-3">
        <div class="modal-side">
          <span id="pleasefuckingcheckinwithmebefordoinganythingmorethancss"></span>
          <ul class="top-submenus">
            <b id="select-text">Select profile picture</b>
            <br><br> <!-- Hacky fix  -->
            <li class="highlighted"><a href="#">Upload</a></li>
            <li><a href="#">Your Photos</a></li>
            <li><a href="#">Photos of you</a></li>
            <li><a href="#">Web camera</a></li>
          </ul>
     
        </div>
      </div>
      
      <div class="col-xs-9">
        <div class="upload-area-pfp" id="pfp-cool">
          <p class="inside-job" id="bwc">Drag a photo here</p> 
          <p class="inside-job" id="lwc">Or if you prefer</p> 
          <button class="ifyouwalkandiwasgone" id="pfp-upload-inside" id="banner-upload">Select a photo from your computer</button>
        </div>
      </div>
    </div>
    <div class="row">
    <div style="margin-left: 420px;" class="modal-bottom">
        <button class="ifyouwalkandiwasgone" id="pfp-upload">Set as profile photo</button>
        <button style="margin-left: -105px;" class="close-banner" id="donotaskwhatwedidtojapaninthe40s">Cancel</button>
      </div>
    </div>
  </div>
</div>

<div class="content">
    <div class="container" id="posts-container">

    <div class="box" id="about-box">
        <h3>Story</h3>

        <strong id="tagline-label">Tagline</strong>
        <p id="tagline-value"></p>
        
        <strong id="intro-label">Introduction</strong>
        <p id="intro-value">Nothng</p>
       
        <strong id="braggingrights-label">Bragging Rights</strong> 
        <p id="braggingrights-value">Unset</span></p>
      
        
        <a id="edit-box-story">Edit</a>
    </div>


    <div class="box" id="info-box">

        <h3>Personal Information</h3>

        <p><strong id="gender-label">Gender:</strong> <span id="gender-value">Unset</span></p>
        <p><strong id="lookingforalaska-label">Networking:</strong> <span id="lookingforalaska-value">Nothng</span></p>
        <p><strong id="birthday-label">Birthday:</strong> <span id="birthday-value">Unset</span></p>
        <p><strong id="relationship-label">Relationship:</strong> <span id="relationship-value">Unset</span></p>
        <p><strong id="othernames-label">Other names:</strong> <span id="othernames-value">Unset</span></p>

        <a id="edit-box-intro">Edit</a>
    </div>


    <div id="editbox-story" class="modal">

    <div class="modal-content-story">

        <div id="colour-title-thingy-info">
            <h3 id="bih3" >Basic Information</h3>
        </div>

        <div id="tagline-con">

        <b id="taglinebob" >Tagline</b>

        <textarea id="tagline-story"> </textarea>

        </div>

        <div id="intro-con">

        <b id="storybob" >Story</b>
        

        <textarea id="storystory"> </textarea>

        </div>

        <div id="brag-con">

        <b id="btagbob" >Bragging rights</b>


        <textarea id="brag-story"> </textarea>

        </div>

        <div id="buttons-row-story">
        
        <div class="modal-bottom">
            <button class="close-banner" id="donotaskwhatwedidtojapaninthe40s">Cancel</button>
            <button class="ifyouwalkandiwasgone" id="save-button-story">Save</button>
        </div>
         
        </div>
    
    </div>
</div>


<div id="editbox-intro" class="modal">
        <div class="modal-content-intro">
            <div id="colour-title-thingy-intro">
                <h3 id="bih3">Personal Information</h3>
            </div>

            <div id="gender-con">
                <b id="genderbob">Gender</b>

                <textarea id="gender-intro"> </textarea>
            </div>

            <div id="networking-con">
                <b id="networkingbob">Networking</b>

                <textarea id="networkingintro"> </textarea>
            </div>

            <div id="baday-con">
                <b id="bdaytagbob">Birthday</b>

                <textarea id="bday-intro" type="number" placeholder="YYYY/MM/DD" oninput="formatDate(this)" maxlength="10"></textarea>
            </div>

            <div id="real-con">
                <b id="realgbob">Relationship</b>

                <textarea id="real-intro"> </textarea>
            </div>

            <div id="othernames-con">
                <b id="othernamesgbob">Other names</b>

                <textarea id="othernames-intro"> </textarea>
            </div>

            <div id="buttons-row-story">
                <div class="modal-bottom">
                    <button class="close-banner-intro" id="donotaskwhatwedidtojapaninthe40s">Cancel</button>
                    <button class="ifyouwalkandiwasgone" id="save-button-intro">Save</button>
                </div>
            </div>
        </div>
    </div>

    
</div>


<script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>

<!-- Main Script-->


<script>

    $('#edit-box-story').on('click', function() {
        $('#editbox-story').show();
    });

    $('#edit-box-intro').on('click', function() {
        $('#editbox-intro').show();
    });

    $('.close-banner').on('click', function() {
        $('#editbox-story').hide();
    });

    $('.close-banner-intro').on('click', function() {
        $('#editbox-intro').hide();
    });

    $(window).on('click', function(event) {
        if ($(event.target).is('#editbox-story')) {
            $('#editbox-story').hide();
        }
    });

    $(window).on('click', function(event) {
        if ($(event.target).is('#editbox-intro')) {
            $('#editbox-intro').hide();
        }
    });
    
</script>

<script>
$(document).ready(function() {

    function fetchAndUpdateUserInfo() {
        var username = '<?php echo $profileget ?>'; 

        $.ajax({
            url: '<?php echo $siteurl?>/apiv1/fetch_about.php?username=' + encodeURIComponent(username),    
            type: 'GET',
            data: { username: username },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    var data = response.data;

                    $('#tagline-value').text(data.tagline || 'Unset');
                    $('#intro-value').text(data.introduction || 'Unset');
                    $('#braggingrights-value').text(data.bragging_rights || 'Unset');

                    // WARNING GENDER OPTION ILLEGAL IN FLORDIA, IDAHO, TEXAS, AND MORE
                    $('#gender-value').text(data.gender || 'Unset');

                    $('#lookingforalaska-value').text(data.networking || 'Unset');
                    
                    $('#birthday-value').text(data.birthday || 'Unset');
                       
                    $('#relationship-value').text(data.relationship || 'Unset');

                    $('#othernames-value').text(data.othernames || 'Unset');
                    
                    
                } else {
                    console.error('Error fetching user info: ', response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error fetching user info: ', error);
            }
        });
    }

    fetchAndUpdateUserInfo();

    function getValueOrDefault(selector, value) {
    if (!value) {
        return $(selector).text().trim() || 'Unset';
    }
        return value;
    }

    
    $('#save-button-story').click(function(e) {
        e.preventDefault(); 

        var tagline = $('#tagline-story').val().trim();
        var introduction = $('#storystory').val().trim();
        var braggingRights = $('#brag-story').val().trim();
        var username = '<?php echo $_SESSION["username"] ?>'; 

        tagline = getValueOrDefault('#tagline-value', tagline);
        introduction = getValueOrDefault('#introduction-value', introduction);
        braggingRights = getValueOrDefault('#braggingrights-value', braggingRights);

        var data = {
            username: username,  
            tagline: tagline,
            introduction: introduction,
            bragging_rights: braggingRights
        };

        $.ajax({
            url: '<?php echo $siteurl?>/apiv1-internal/about_update.php',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(data),  
            success: function(response) {

            console.log("Raw Response:", response);

            if (typeof response === 'object') {

                fetchAndUpdateUserInfo();
                $('#editbox-story').hide();

                if (response.action === 'error') {
                    fetchAndUpdateUserInfo();
                    alert('Failed to update opps')
                }

            }

            fetchAndUpdateUserInfo();

            },
            error: function(xhr, status, error) {

                console.error("Error updating information: ", error);
                alert("Failed to update information. Please try again.");
            }
        }); 
    });

    $('#save-button-intro').click(function(e) {
    e.preventDefault(); 

    var gender = $('#gender-intro').val().trim();
    var networking = $('#networkingintro').val().trim();
    var birthday = $('#bday-intro').val().trim();
    var relationship = $('#real-intro').val().trim();
    var othernames = $('#othernames-intro').val().trim();
    var username = '<?php echo $_SESSION["username"] ?>';

    gender = getValueOrDefault('#gender-value', gender);
    networking = getValueOrDefault('#networking-value', networking);
    birthday = getValueOrDefault('#birthday-value', birthday);
    relationship = getValueOrDefault('#relationship-value', relationship);
    othernames = getValueOrDefault('#othernames-value', othernames);


    function formatDate(textarea) {
        var value = textarea.value.replace(/[^0-9\/]/g, '');

        var formattedValue = value
            .replace(/(\d{4})(\d{0,2})/, '$1/$2')  
            .replace(/(\d{4}\/\d{2})(\d{0,2})/, '$1/$2') 
            .substring(0, 10); 

        textarea.value = formattedValue;
    }

    function isValidDate(dateString) {
        var regex = /^\d{4}-\d{2}-\d{2}$/;
        if (!regex.test(dateString)) return false;

        var date = new Date(dateString);
        var timestamp = date.getTime();

        return !isNaN(timestamp) && date.toISOString().slice(0, 10) === dateString;
        }

        if (birthday && !isValidDate(birthday)) {
        alert("Please enter a valid date in the format YYYY-MM-DD.");
        return;
    }

    var data = {
        username: username,  
        gender: gender,
        networking: networking,
        birthday: birthday,
        relationship: relationship,
        othernames: othernames
    };

    $.ajax({
        url: '<?php echo $siteurl?>/apiv1-internal/about_update.php',
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify(data),  
        success: function(response) {
            console.log("Raw Response:", response);

            if (response.status === 'success') {
                fetchAndUpdateUserInfo();
                $('#editbox-intro').hide();
                alert('Information updated successfully!');
            } else {
                alert('Failed to update: ' + response.message);
            }
        },
        error: function(xhr, status, error) {
            console.error("Error updating information: ", error);
            alert("Failed to update information. Please try again.");
        }
    }); 
});

    
});
</script>

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
    
$(document).ready(function() {
    const sidebar = $('.sidebar');
    const openSidebarButton = $('#open-sidebar');
    let sidebarOpen = false;  // Set to false by default since the sidebar is likely closed initially

    openSidebarButton.on('click', function(event) {
        event.stopPropagation();  // Prevent the click from bubbling up to the document-level handler
        if (sidebarOpen) {
            sidebar.css('transform', 'translateX(-100%)');
        } else {
            sidebar.css('transform', 'translateX(0)');
        }
        sidebarOpen = !sidebarOpen;  // Toggle sidebar state
    });

    $(document).on('click', function(event) {
        if (sidebarOpen && !$(event.target).closest('.sidebar').length && !$(event.target).is('#open-sidebar')) {
            sidebar.css('transform', 'translateX(-100%)');
            sidebarOpen = false;
        }
    });
});

$(document).ready(function() {
    const sidebar = $('.sidebar');
    const openSidebarButton = $('#open-sidebar-1');
    let sidebarOpen = false;  // Set to false by default since the sidebar is likely closed initially

    openSidebarButton.on('click', function(event) {
        event.stopPropagation();  // Prevent the click from bubbling up to the document-level handler
        if (sidebarOpen) {
            sidebar.css('transform', 'translateX(-100%)');
        } else {
            sidebar.css('transform', 'translateX(0)');
        }
        sidebarOpen = !sidebarOpen;  // Toggle sidebar state
    });

    $(document).on('click', function(event) {
        if (sidebarOpen && !$(event.target).closest('.sidebar').length && !$(event.target).is('#open-sidebar')) {
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

<!-- This is FYI for the PFP modal, the above one for the Banner/Cover one-->

<script>

$(document).ready(function() {
    var selectedFileOther;

    function handleFileUpload(file) {
        var formData = new FormData();
        formData.append('username', '<?php echo $_SESSION["username"]?>');
        formData.append('banner', file);
        $.ajax({
            url: '<?php echo $siteurl ?>/apiv1-internal/upload_pfp.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                alert(response);
                var timestamp = new Date().getTime();
                var newImageUrl = '<?php echo $siteurl ?>/apiv1/fetch_pfp_api.php?name=<?php echo $profileget ?>&_=' + timestamp;
                $(".pfp-picture").attr("src", newImageUrl);
            },
            error: function(xhr, status, error) {
                alert("Failed to upload banner. Error: " + error);
            }
        });
    }
    
    $('#pfp-upload-inside').click(function() {
        $('<input type="file" accept="image/png,image/webp,image/jpeg,image/jpg">').change(function() {
            selectedFileOther = this.files[0];
        }).click();
    });
    
    $('.upload-area-pfp').on('drop', function(e) {
        e.preventDefault();
        selectedFileOther = e.originalEvent.dataTransfer.files[0];
        handleFileUpload(selectedFileOther);
    }).on('dragover', function(e) {
        e.preventDefault();
    });
    
    $('#pfp-upload').click(function(e) {
        e.preventDefault();
        if (selectedFileOther) {
            handleFileUpload(selectedFileOther);
        } else {
            alert("Please select a photo first.");
        }
    });
});

 $(".change-photo-button").click(function() {
        $("#uploadbanner-pfp").css("display", "block");
    });

    $("#donotaskwhatwedidtojapaninthe40s, #boi1, #uploadbanner-banner-banner .close").click(function() {
        $("#uploadbanner-pfp").css("display", "none");
 });

 function smoothReload(delay) {
    setTimeout(function() {
        location.reload();
    }, delay);
}
</script>

<script>

$(document).ready(function() {
    var selectedFileOther;

    function handleFileUpload(file) {
        var formData = new FormData();
        formData.append('username', '<?php echo $_SESSION["username"]?>');
        formData.append('banner', file);
        $.ajax({
            url: '<?php echo $siteurl ?>/apiv1-internal/upload_banner.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                alert(response);
                var timestamp = new Date().getTime();
                var newImageUrl = '<?php echo $siteurl ?>/apiv1/fetch_banner_api.php?name=<?php echo $profileget ?>&_=' + timestamp;
                
                var gradient = "linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5))";

                $(".bg-grad").css("background", `${gradient}, url('${newImageUrl}')`);

            },
            error: function(xhr, status, error) {
                alert("Failed to upload banner. Error: " + error);
            }
        });
    }
    
    $('#banner-upload-inside-cool').click(function() {
        $('<input type="file" accept="image/png,image/webp,image/jpeg,image/jpg">').change(function() {
            selectedFileOther = this.files[0];
        }).click();
    });
    
    $('.upload-area-banner').on('drop', function(e) {
        e.preventDefault();
        selectedFileOther = e.originalEvent.dataTransfer.files[0];
        handleFileUpload(selectedFileOther);
    }).on('dragover', function(e) {
        e.preventDefault();
    });
    
    $('#banner-upload').click(function(e) {
        e.preventDefault();
        if (selectedFileOther) {
            handleFileUpload(selectedFileOther);
        } else {
            alert("Please select a photo first.");
        }
    });
});

 $(".fuckjohnhinckleyjunior").click(function() {
        $("#uploadbanner-banner-banner").css("display", "block");
    });

    $("#donotaskwhatwedidtojapaninthe40s, #boi1, #uploadbanner-banner-banner .close, .close-banner").click(function() {
        $("#uploadbanner-banner-banner").css("display", "none");
 });

 function smoothReload(delay) {
    setTimeout(function() {
        location.reload();
    }, delay);
}
</script>

<!-- END SCRIPTS -->

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

$('.change-photo-button').hide();

$('.pfp-picture').mouseenter(function() {
    $('.change-photo-button').show();
});

$('.pfp-picture').mouseleave(function() {
    $('.change-photo-button').hide();
});

$(document).ready(function() {
    setInterval(function() {

        var width = $(window).width();
        var height = $(window).height();
        
        console.log("Screen Resolution: " + width + "x" + height);
    }, 2500);
});
</script>

<script src="assets/js/sidebar.js"></script>
<script src="assets/js/sidebar.js"></script>
<script src="assets/js/funshit.js"></script>
<script src="assets/js/fixes.js"></script>

</body>
</html>
