<?php

session_start();


include("important/db.php");

$profileget = htmlspecialchars($_GET['profile']);

$username = $_GET['username'];

?>

<ul class="nav nav-tabs" style="margin: 0 auto;">
    
    <?php if ($icon == 'home') { ?>
        <li role="presentation" class="active"><a href="#">All</a></li>
        <li role="presentation"><a href="#">Family</a></li>
        <li role="presentation"><a href="#">Friends</a></li>
        <li role="presentation" class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
               aria-expanded="false">
                More <span class="caret"></span>
            </a>
            
            <ul class="dropdown-menu">
                <li><a href="#">janovski_cz stop whining</a></li>
                <li><a href="#">Regean</a></li>
                <li><a href="#">Geroge W. Bush</a></li>
            </ul>
        </li>

        <?php } elseif ($icon == 'profile') { ?>
            <li role="presentation"><a href="about.php?profile=<?php echo $profileget ?>&icon=about">About</a></li>
            <li role="presentation" class="active"><a href="#">Posts</a></li>
            <li role="presentation"><a href="photos.php?username=<?php echo $profileget?>">Photos</a></li>
        <?php } elseif ($icon == 'communities') { ?>
            <li role="presentation" class="active"><a href="#">All Communities</a></li>
            <li role="presentation"><a href="#">Recommended for you</a></li>
            <li role="presentation"><a href="#">Your Communities</a></li>
        <?php } elseif ($icon == 'photos') { ?>
            <li role="presentation"><a href="about.php?profile=<?php echo $username?>&icon=about">About</a></li>
            <li role="presentation"><a href="profile.php?profile=<?php echo $username?>">Posts</a></li>
            <li role="presentation" class="active"><a id="bobuncleyour" href="#" class="active">Photos</a></li>
        <?php } elseif ($icon == 'search') { ?>
            <li role="presentation" class="active"><a id="bobuncleyour" href="#" class="active">Everything</a></li>
        <?php }  elseif ($icon == 'about') { ?>
            <li role="presentation" class="active"><a href="#">About</a></li>
            <li role="presentation"><a href="profile.php?profile=<?php echo $profileget?>">Posts</a></li>
            <li role="presentation" ><a id="bobuncleyour" href="photos.php?username=<?php echo $profileget?>" class="active">Photos</a></li>
        <?php } ?>
    </ul>
