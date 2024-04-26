<?php

include("../important/db.php");

if(isset($_POST['username']) && isset($_FILES['banner'])) {
    $username = $_POST['username'];
    $bannerFile = $_FILES['banner'];

    $uploadDirectory = '../assets/covers/';

    $allowedExtensions = array('png', 'jpg', 'webp', 'jpeg'); 
    $maxFileSize = 2048 * 2048;

    $fileExtension = strtolower(pathinfo($bannerFile['name'], PATHINFO_EXTENSION));
    $fileSize = $bannerFile['size'];

    if(in_array($fileExtension, $allowedExtensions) && $fileSize < $maxFileSize) {
        $existingImagePath = $uploadDirectory . $username . '.*';
        array_map('unlink', glob($existingImagePath));

        $bannerFileName = $username . '.' . $fileExtension;
        $bannerFilePath = $uploadDirectory . $bannerFileName;
        
        if(move_uploaded_file($bannerFile['tmp_name'], $bannerFilePath)) {
            echo "Profile picture uploaded successfully.";
        } else {
            echo "Failed to upload cover picture.";
        }
    } else {
        echo "Invalid file format or size. Please upload a PNG or JPG file less than 1MB.";
    }
} else {
    echo "Community ID or cover picture file not provided.";
}

?>

