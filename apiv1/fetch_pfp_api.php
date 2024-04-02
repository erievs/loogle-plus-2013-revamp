<?php
$profilePicturesDirectory = '../assets/profilepictures/';
    
$availableProfilePictures = array(
    'default1.jpg',
    'default2.jpg',
    'default3.jpg',
    'default4.jpg'
);

$allowedExtensions = array('jpg', 'jpeg', 'png', 'webp');

if(isset($_GET['name'])) {
    $requestedProfilePicture = $_GET['name'];
    foreach ($allowedExtensions as $extension) {
        $requestedProfilePicturePath = $profilePicturesDirectory . $requestedProfilePicture . ".$extension";
        if(file_exists($requestedProfilePicturePath)) {
            $mimeType = mime_content_type($requestedProfilePicturePath);
            header("Content-Type: $mimeType"); 
            readfile($requestedProfilePicturePath);
            exit;
        }
    }

    $randomProfilePicture = $availableProfilePictures[array_rand($availableProfilePictures)];
    foreach ($allowedExtensions as $extension) {
        $randomProfilePicturePath = $profilePicturesDirectory . $randomProfilePicture;
        if(file_exists($randomProfilePicturePath)) {
            $mimeType = mime_content_type($randomProfilePicturePath);
            header("Content-Type: $mimeType");
            readfile($randomProfilePicturePath);
            exit;
        }
    }

    $defaultProfilePicturePath = $profilePicturesDirectory . 'default.jpg';
    if(file_exists($defaultProfilePicturePath)) {
        $mimeType = mime_content_type($defaultProfilePicturePath);
        header("Content-Type: $mimeType");
        readfile($defaultProfilePicturePath);
        exit;
    } else {
        echo "Default profile picture not found.";
    }
} else {
    echo "No profile picture name provided.";
}
?>
