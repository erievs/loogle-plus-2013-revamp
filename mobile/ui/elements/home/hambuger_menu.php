<div class="sidebar" id="sidebar">
    <?php

    $username = isset($_SESSION['username']) ? $_SESSION['username'] : 'your_default_username';

    $profileImagePath = "../assets/banners/{$username}_banner.jpg";
    $defaultImagePath = "../assets/banners/default.jpg";

    $imageSource = file_exists($profileImagePath) ? $profileImagePath : $defaultImagePath;
    ?>

    <div class="image-username-container">
        <img src="<?php echo $imageSource; ?>" alt="Profile Image">
        <p class="username-overlay" style="color: white; font-weight: bold;"> <?php echo $username; ?></p>
    </div>
    <div class="sidebar-content">

    </div>
</div>
