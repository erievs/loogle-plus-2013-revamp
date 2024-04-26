<?php 

$current_url = $_SERVER['REQUEST_URI'];

$icon = "home";

if (strpos($current_url, 'whats_hot.php') !== false) {
    $icon = "whats_hot";
} elseif (strpos($current_url, 'profile.php') !== false) {
    $icon = "profile";
} elseif (strpos($current_url, 'communties.php') !== false) {
    $icon = "communties";
}  elseif (strpos($current_url, 'photos.php') !== false) {
    $icon = "photos";
}

$profileget = htmlspecialchars($_GET['profile']);
$photoget = htmlspecialchars($_GET['username']);

?>



<script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
<link rel="stylesheet" href="assets/css/headerfix.css">
<link rel="stylesheet" href="assets/css/writepost.css">

<script>

    
$(document).ready(function() {
  let isHeaderVisible = false;

  $('.notif-icon-side').click(function(event) {
    event.stopPropagation(); 
    console.log("Notification icon clicked");
    if (!isHeaderVisible) {
      $('#notificationContainer, .sb-card-body-arrow').css('display', 'block');
      isHeaderVisible = true;
    }
  });

  $(document).click(function() {
    if (isHeaderVisible) {
      $('#notificationContainer, .sb-card-body-arrow').css('display', 'none');
      isHeaderVisible = false;
    }
  });

  $(document).keyup(function(e) {
    if (e.key === "Escape" && isHeaderVisible) {
      $('#notificationContainer, .sb-card-body-arrow').css('display', 'none');
      isHeaderVisible = false;
    }
  });
});

$(document).ready(function () {

    $(".notif-icon").click(function () {
        $("#notificationContainer, #notificationTriangle, .sb-card-body-arrow").toggle();
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
            username: "<?php echo $_SESSION['username']?>" 
        },
        success: function (data) {
            const mentions = JSON.parse(data);

            if (mentions.length > 0) {
                $.each(mentions, function (index, mention) {
                    const mentionDiv = $("<div>").addClass("mention");
                    const pfpImage = $("<img>").attr({
                        src: "/assets/icons/default.png",
                        alt: "PFP",
                    }).addClass("not-pfp-image");


                    const textContainer = $("<div>").addClass("not-text-container");
                    const usernameDiv = $("<div>").text(mention.sender).addClass("not-username");
                    const contentDiv = $("<div>").text(mention.content).addClass("not-content");
					const toplol = $("<div>").addClass("topper");
					const hackyfix = $("<div>").addClass("hacky-fix");
					const looglepluslogo = $("<div>").addClass("gplus");
					const edxit = $("<div>").addClass("exit");
					
					hackyfix.append(looglepluslogo, edxit);
					toplol.append(hackyfix);
                    textContainer.append(usernameDiv, contentDiv);
                    mentionDiv.append(pfpImage, textContainer, toplol);

                    $("#mentionsContainer").append(mentionDiv);

                    mentionDiv.click(function () {
                        dismissMention($(this), mention.post_id);
                    });
                });
            } else {
                var gifImage = $('<img src="https://i.imgur.com/EfkPqbX.png" style="scale: 0.6;" alt="Jingle GIF" />');
                    $("#mentionsContainer").after(gifImage);
                    $("#mentionsContainer").html("<p style='position: relative; top: 40px;'>All caught up!</p>");

                gifImage.click(function() {
                 var originalSrc = $(this).attr('src');
                 $(this).attr('src', 'http://googlerock.free.fr/images/mr._jingles/Jingle_2_2013.gif');
                 $(this).toggleClass("play-animation");
    
                      setTimeout(function() {
                        gifImage.attr('src', originalSrc);
                        $(this).attr('src', 'https://i.imgur.com/EfkPqbX.png');
                  }, 1750);
             });
            }
        },
    });
}


 function dismissMention(mentionElement, postId) {

    mentionElement.fadeOut(300, function () {
        $(this).remove();
        console.log(postId);
        window.location.href = '<?php echo $siteurl; ?>/view_post.php?id=' + postId;
    });


    $.ajax({
        url: "<?php echo $siteurl; ?>/apiv1/toggle_notification_status.php",
        type: "POST",
        data: {
            username: "<?php echo $_SESSION['username']?>",
            post_id: postId
        },
        success: function (response) {
        },
        error: function (xhr, status, error) {
        }
    });
}

</script>

<div class="sticky-header" style="display: none;">
    <div class="menu">
    <span id="loogle-logo" class="loogle-logo"></span>
    <span class="<?php 
            if ($icon == "whats_hot") {
                echo 'home-h-icon';
            } elseif ($icon == "profile") {
                echo 'profile-p-icon';
            } elseif ($icon == "home") {
                echo 'home-h-icon';
            }  elseif ($icon == "communties") {
                echo 'com-c-icon';
            } elseif ($icon == "photos") {
                echo 'photo-p-icon';
            }
	?>" id="open-sidebar-1"></span>  <p style="font-size: 16px;top: 2px;position: relative;"> > </p>

        <span class="divider"></span>
        <?php include("navtabs.php"); ?>
    </div>
</div>

<div class="main-header">
    <a href="/">
	 <img class="logo" src="/assets/images/logo.png" alt="Logo">
	</a>
    <div class="search-container">
		<form>
        <input class="search-bar" type="text">
        <button class="ifyouwalkandiwasgone" id="ronnieisnum1" type="submit">
		 <span class="fromthehousewemadeourhome"></span>
		</button>
		</form>
    </div>  



<div class="notif-icon-side">

<div class="unread-squares" style="">
<p></p>
</div>
    <div class="notif-icon"><p id="numsfornot"></p></div>
    <span id="notfication-header">
    <div class="sb-card-body-arrow" style="display: none;" ></div>
    <div id="notificationContainer" style=" display: none; color: #aaa; max-height: 500px; overflow-y: auto;">
            <span class="title" style="color: #6f6f6f; text-align: center; font-size: 15px;">Loogle+ notifications</span>
            <br />
            <br />
            <div id="mentionsContainer"></div>
    </div>
    </span>
</div>

<div class="hacky-fix">
<div class="username-header">+<?php echo isset($_SESSION["username"]) ? $_SESSION["username"] : "Your Username";?>
</div>
<a href="<?php echo $siteurl; ?>/profile.php?profile=<?php echo $_SESSION['username']?>">
<img class="pf-picture" src="<?php echo $siteurl; ?>/apiv1/fetch_pfp_api.php?name=<?php echo $_SESSION['username']?>">
</a>
</div>
</div>

<div class="sidebar">
    <ul>
        <li>
		 <span class="icon" id="sel">
		  <a class="sidebar-list" href="/">
		   <div class="home-icon-side"></div>
		   <p><?php 
	if ($icon == "profile") {
		echo 'Profile';
	}
	
	if ($icon == "whats_hot") {
		echo 'Home';
	}

    if ($icon == "home") {
		echo 'Home';
	}

    if ($icon == "communties") {
		echo 'Communties';
	}

    if ($icon == "photos") {
		echo 'Photos';
	}

	?></p>
		  </a>
		 </span>
		</li>
		
        <li>
		 <span class="icon" id="non-sel">
		  <a class="sidebar-list" href="<?php echo $siteurl; ?>/profile.php?profile=<?php echo $_SESSION['username']?>">
		   <div class="profile-icon-side"></div> 
		   <p>Profile</p>
		  </a>
		 </span>
		</li>
		
        <li>
		 <span class="icon" id="non-sel">
		  <a class="sidebar-list" href="#">
		   <div class="people-icon-side"></div> 
		   <p>People </p>
		  </a>
		 </span>
		</li>
        
        <span class="icon" id="non-sel">
		  <a class="sidebar-list" href="photos.php?username=<?php echo $_SESSION["username"];?>">
		   <div class="photo-icon-side"></div> 
		   <p>Photos </p>
		  </a>
		 </span>
		</li>

        <hr>

        <a href="whats_hot.php"><li><span class="icon" id="non-sel"><div class="wh-icon-side"></div> <p>What's Hot<p></span></li></a>
        <a href="communties.php"><li><span class="icon" id="non-sel"><div class="com-icon-side"></div> <p>Communties<p></span></li></a>
        <li><span class="icon" id="non-sel"><div class="events-icon-side"></div> <p>Events<p></li>
        <li><span class="icon" id="non-sel"><div class="settings-icon-side"></div> <p>Settings<p></li>
    </ul>
</div>

<div class="sub-header">

<div id="open-sidebar">
    <span class="<?php 
        if ($icon == "profile") {
            echo 'profile-p-icon';
        } elseif ($icon == "home") {
            echo 'home-h-icon';
        } elseif ($icon == "whats_hot") {
            echo 'hot-h-icon';
        } elseif ($icon == "communties") {
            echo 'com-c-icon';
        } elseif ($icon == "photos") {
            echo 'photo-p-icon';
        }
    ?> home-icon"></span>
    <span class="home-icon"><?php 
        if ($icon == "profile") {
            echo 'Profile';
        } elseif ($icon == "home") {
            echo 'Home';
        }  elseif ($icon == "whats_hot") {
            echo 'Whats Hot';
        } elseif ($icon == "communties") {
            echo 'Communties';
        } elseif ($icon == "photos") {
            echo 'Photos';
        }
    ?> </span>
    <span class="arrow-icon"> > </span>
</div>

    <div class="menu">
        <span class="divider"></span>
        <?php include("navtabs.php"); ?>
    </div>
</div>

<script>
$(document).ready(function() {
    $.ajax({
        url: '<?php echo $siteurl; ?>/apiv1/fetch_unreads.php?username=<?php echo $_SESSION['username']?>',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            console.log('Data received:', data);
            var unreadCount = data.total_unread;
            $('#numsfornot').text(unreadCount);
            if (unreadCount > 0) {
                $('.notif-icon').css('background-color', '#c44430');
            }
        },
        error: function(xhr, status, error) {
            console.error('Error fetching data from API:', error);
        }
    });
});
</script>

