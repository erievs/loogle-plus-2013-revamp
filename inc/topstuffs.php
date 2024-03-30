<?php if (!isset($icon)) {
	$icon = "home";
}?>
<script>

$(document).ready(function() {
  let isHeaderVisible = false;

  $('.notif-icon-side').click(function() {
    console.log("Notification icon clicked");
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
                $("#mentionsContainer").html("<p>All caught up!</p>");
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
	if ($icon == "profile") {
		echo 'profile-p-icon';
	}
	
	if ($icon == "home") {
		echo 'home-h-icon';
	}
	
	?> home-icon" id="open-sidebar-1"></span>
    <p style="font-size: 16px;
top: 2px;
position: relative;"> > </p>
	
	


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
        <button class="ifyouwalkandiwasgone" type="submit">
		 <span class="fromthehousewemadeourhome"></span>
		</button>
		</form>
    </div>  



<div class="notif-icon-side">
    <div class="notif-icon"></div>
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
<img class="pf-picture" src="<?php echo 'assets/profilepics/' . $_SESSION["username"] . '.png';?>">
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
	
	if ($icon == "home") {
		echo 'Home';
	}
	
	
	?></p>
		  </a>
		 </span>
		</li>
		
        <li>
		 <span class="icon" id="non-sel">
		  <a class="sidebar-list" href="/profile.php?profile=<?php echo $_SESSION['username']?>">
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

        <hr>

        <li><span class="icon" id="non-sel"><div class="wh-icon-side"></div> <p>What's Hot<p></span></li>
        <li><span class="icon" id="non-sel"><div class="com-icon-side"></div> <p>Communties<p></span></li>
        <li><span class="icon" id="non-sel"><div class="events-icon-side"></div> <p>Events<p></li>
        <li><span class="icon" id="non-sel"><div class="settings-icon-side"></div> <p>Settings<p></li>
    </ul>
</div>
<div class="sub-header">
	<div id="open-sidebar">
     <span class="<?php 
	if ($icon == "profile") {
		echo 'profile-p-icon';
	}
	
	if ($icon == "home") {
		echo 'home-h-icon';
	}
	
	
	?>  home-icon"></span>
     <span class="home-icon"><?php 
	if ($icon == "profile") {
		echo 'Profile';
	}
	
	if ($icon == "home") {
		echo 'Home';
	}
	
	
	?> </span>
     <span class="arrow-icon"> > </span>
	</div>

    <div class="menu">
        <span class="divider"></span>
        <?php include("navtabs.php"); ?>
    </div>
</div>