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
 


    <title>Loogle+</title>
	<link rel="stylesheet" href="assets/css/2013isamess.css">
	<link rel="stylesheet" href="assets/css/2013indexres.css">
	<link rel="stylesheet" href="assets/css/2013notes.css">
    <link rel="stylesheet" href="assets/css/univesalcoolstuff.css">
    <link rel="stylesheet" href="assets/css/headerfix.css">
    <link rel="stylesheet" href="assets/css/community.css">
    <link rel="icon" 
      type="image/png" 
      href="assets/important-images/fav.png" />

</head>
<body>

<?php require_once("inc/topstuffs.php")?>

<!-- I cannot spell -->

<div class="coumminity-con">
    <div id="coms-you-in">
        <div id="top">
        <span id="info-top-stuff-1"> 
        
        <h3 id="okayyoucanalsocryonapril22becausetrickydickdiedthatday">Communties you've joined</h3>


        <button id="bobisshit" class="ihavestrongfeelingsagaistaman" type="submit">
                <p>Create Community</p>
        </button>

        </span>
        </div>

        <div id="stuff-thingys">

        </div>

        <div id="whatwein">

        </div>

    </div>

    <div id="coms-you-must-join-you-hippie">
        <h3 id="trickydickdiedthatday">Recommended Communties</h3>
    </div>

    <div id="emerwhatthesigma">

    </div>

<div>

<div class="create-community" class="modal">
  <div class="modal-content">
    <br>
    <div id="top-stuff-2">
        <p>What kind of community are you making?</p>
    </div>
 
    <div id="make-thing">
        <span id="top-mt">
        <p id="st1">Public</p>
        </span>

        <span id="text-mt">
        <p id="st2">What do you want to call it?</p>
        </span>

        <span id="input-mt">
        <textarea class="ta-mt" id="ci1"></textarea>
        </span>
  </div>

    <div id="bottom-stuff">
        
        <button id="menshallonlycryonthe5thofjune" class="ihavestrongfeelingsagaistaman" type="submit">
                <p id="st3">Cancel</p>
        </button>

        <button id="loogleshutdownjune4th" class="ihavestrongfeelingsagaistaman" type="submit">
                <p>Create Community</p>
        </button>

    </div>

  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>

<script>

    $(".create-community").hide();

    function smoothReload(delay) {
    $("body").fadeOut(delay, function() {
        history.replaceState({}, document.title, window.location.pathname);
        location.reload();
        });
    }
    
    $("#menshallonlycryonthe5thofjune").click(function() {
        $(".create-community").hide();
    });

    $("#bobisshit").click(function() {
        $(".create-community").show();
    });

    $('#loogleshutdownjune4th').click(function() {
        
        var communityName = $('#ci1').val(); 

        if (communityName === '') {
            alert('Please enter a community name.');
            return;
        }

        $.ajax({
            type: 'POST',
            url: '<?php echo $siteurl?>/apiv1/create_community.php',
            data: {
                name: communityName,
                creator_username: '<?php echo $_SESSION["username"]; ?>' 
            },
            success: function(response) {
                if (response.status === 'success') {
                    $(".create-community").hide();
                    smoothReload(500);  
                    smoothRel
                } else {
                    $(".create-community").hide();
                    smoothReload(500);
                }
            },
            error: function(xhr, status, error) {
                alert('Error: ' + error);
            }
        });
    });


    $.ajax({
        url: '<?php echo $siteurl ?>/apiv1/fetch_all_coms.php?username=<?php echo $_SESSION["username"];?>',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            var container = $('#whatwein');

            $.each(data, function(index, community) {
                var card = $('<div class="card"></div>');

                var image = $('<img class="card-img" src="<?php echo $siteurl ?>/apiv1/fetch_cover_api.php?cover=' + community.community_id + '" style="width: 50%;">');

                card.append(image);
 
                var name = $('<div class="card-name">' + community.name + '</div>');
                card.append(name);

                var membersArray = community.members_list.split(':');
                var membersCount = membersArray.length - 1; 
                var members = $('<div class="card-members">Members: ' + membersCount + '</div>');
                card.append(members);

                container.append(card);
            });
        },
        error: function(xhr, status, error) {
            console.error('Error fetching community data: ' + error);
        }
    });

    $.ajax({
        url: '<?php echo $siteurl ?>/apiv1/fetch_all_coms.php',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            var container = $('#emerwhatthesigma');

            $.each(data, function(index, community) {
                var card = $('<div class="card-other"></div>');

                var image = $('<img style="100%" class="card-img-other" src="<?php echo $siteurl ?>/apiv1/fetch_cover_api.php?cover=' + community.community_id + '" style="width: 50%;">');

                card.append(image);
 
                var name = $('<div class="card-name-other">' + community.name + '</div>');
                card.append(name);

                var membersArray = community.members_list.split(':');
                var membersCount = membersArray.length - 1; 
                var members = $('<div class="card-members-other">Members: ' + membersCount + '  Posts: ' + community.total_posts + '</div>');
                card.append(members);

                var image1 = $('<img style="100%" class="card-img-two" src="<?php echo $siteurl ?>/apiv1/fetch_cover_api.php?cover=' + community.community_id + '" style="width: 50%;">');
                card.append(image1);

                container.append(card);
            });
        },
        error: function(xhr, status, error) {
            console.error('Error fetching community data: ' + error);
        }
    });


</script>

<script>
$(document).ready(function() {
    const sidebar = $('.sidebar'); 
    const openSidebarButton = $('.com-c-icon'); 
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
        if (sidebarOpen && !$(event.target).closest('.coumminity-con').length && !$(event.target).is(openSidebarButton)) {
            sidebar.css('transform', 'translateX(-100%)');
            sidebarOpen = false;
        }
    });
});


</script>
