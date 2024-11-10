<?php

session_start();

include("../important/db.php");

$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
if (parse_url($referer, PHP_URL_HOST) !== parse_url($siteurl, PHP_URL_HOST)) {
    echo "Invalid request origin.";
    exit();
}

if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
    echo "Unauthorized access. Please log in.";
    exit();
}

$username = $_SESSION['username'];

if (isset($_POST['username']) && isset($_FILES['banner'])) {
    $postUsername = $_POST['username'];
    $bannerFile = $_FILES['banner'];

    if ($postUsername !== $username) {
        echo "Unauthorized action. You can only upload banners for your own account.";
        exit();
    }

    $uploadDirectory = '../assets/banners/';
    $allowedExtensions = array('png', 'jpg', 'jpeg', 'webp');
    $maxFileSize = 2048 * 2048; 

    $fileExtension = strtolower(pathinfo($bannerFile['name'], PATHINFO_EXTENSION));
    $fileSize = $bannerFile['size'];

    if (in_array($fileExtension, $allowedExtensions) && $fileSize < $maxFileSize) {

        $existingImagePath = $uploadDirectory . $username . '.*';
        array_map('unlink', glob($existingImagePath));

        $bannerFileName = $username . '.' . $fileExtension;
        $bannerFilePath = $uploadDirectory . $bannerFileName;

        if (move_uploaded_file($bannerFile['tmp_name'], $bannerFilePath)) {
            echo "Banner uploaded successfully.";
        } else {
            echo "Failed to upload banner.";
        }
    } else {
        echo "Invalid file format or size. Please upload a PNG, JPG, JPEG, or WEBP file less than 2MB.";
    }
} else {
    echo "Username or banner file not provided.";
}
?>