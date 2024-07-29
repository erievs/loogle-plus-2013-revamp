<?php 
session_start();
include("important/db.php");
$username = $_SESSION["username"];
?>

<header class="nav-wrapper">
    <div class="left-shit">
        <a id="menu-icon" class="sidenav-trigger" style="cursor: pointer;">
            <i class="material-icons" style="vertical-align: middle; margin-bottom: 2px; color: white;">menu</i>
        </a>
        <a href="/" class="get-tf-away-bitch">
            <img src="<?php echo $siteurl; ?>/exp/2015/assets/images/loogleplus.png" class="home-bound" />
        </a> <p id="home-text-navbar">Home</div>
    </div>
    <div class="current-user">
        <img id="pfp-navbar" src="<?php echo $siteurl; ?>/apiv1/fetch_pfp_api.php?name=<?php echo $username?>" class="home-bound" />
    </div>
</header>
