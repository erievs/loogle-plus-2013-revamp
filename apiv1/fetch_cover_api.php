<?php

include("../important/db.php");

function getImageFromDatabase() {
    global $siteurl, $db_host, $db_user, $db_pass, $db_name;

    if (!isset($_GET['cover'])) {
        http_response_code(400);
        die('No profile id (?cover=whatever_id) provided');
    }

    $username = $_GET['cover'];

    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $banner_url = null;
    $profile_picture_url = null;

    $banner_extensions = ['.jpg', '.webp', '.png'];
    foreach ($banner_extensions as $extension) {
        $banner_path = "../assets/covers/{$username}{$extension}";
        if (file_exists($banner_path)) {
            $banner_url = $banner_path;
            break;
        }
    }

    $profile_picture_extensions = ['.jpg', '.webp', '.png'];
    foreach ($profile_picture_extensions as $extension) {
        $profile_picture_path = "../assets/covers/{$username}{$extension}";
        if (file_exists($profile_picture_path)) {
            $profile_picture_url = $profile_picture_path;
            break;
        }
    }

    $conn->close();

    if ($banner_url !== null) {
        header('Content-Type: image/jpeg'); 
        readfile($banner_url);
    } elseif ($profile_picture_url !== null) {
        header('Content-Type: image/jpeg'); 
        readfile($profile_picture_url); 
    } else {
        $defaultProfilePicturePath = "../assets/covers/default1.jpg";
        if (file_exists($defaultProfilePicturePath)) {
            header('Content-Type: image/jpeg');
            readfile($defaultProfilePicturePath);
        } else {
            http_response_code(404);
            die('Default image not found');
        }
    }
}

getImageFromDatabase();
?>
