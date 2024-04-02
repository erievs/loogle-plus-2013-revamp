<?php

include("../important/db.php");

if(isset($_POST['username']) && isset($_FILES['banner'])) {
    $username = $_POST['username'];
    $bannerFile = $_FILES['banner'];

    $uploadDirectory = '../assets/profilepictures/';

    $allowedExtensions = array('png');
    $maxFileSize = 1024 * 1024;

    $fileExtension = pathinfo($bannerFile['name'], PATHINFO_EXTENSION);
    $fileSize = $bannerFile['size'];

    if(in_array(strtolower($fileExtension), $allowedExtensions) && $fileSize < $maxFileSize) {
        $bannerFileName = $username . '.png';
        $bannerFilePath = $uploadDirectory . $bannerFileName;
        
        if(move_uploaded_file($bannerFile['tmp_name'], $bannerFilePath)) {
            echo "Pfp uploaded successfully.";
        } else {
            echo "Failed to upload pfp.";
        }
    } else {
        echo "Invalid file format or size. Please upload a PNG file less than 1MB.";
    }
} else {
    echo "Username or pfp file not provided.";
}

?>
