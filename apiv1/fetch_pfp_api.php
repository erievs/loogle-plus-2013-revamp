<?php
$profilePicturesDirectory = '../assets/profilepictures/';

$availableProfilePictures = array(
    'default1.jpg',
    'default2.jpg',
    'default3.jpg',
    'default4.jpg'
);

if(isset($_GET['name'])) {
    $requestedProfilePicture = $_GET['name'];
    $requestedProfilePicturePath = $profilePicturesDirectory . $requestedProfilePicture . ".jpg";

    if(file_exists($requestedProfilePicturePath)) {
        header('Content-Type: image/jpeg'); 
        readfile($requestedProfilePicturePath);
        exit;
    } else {
        $randomProfilePicture = $availableProfilePictures[array_rand($availableProfilePictures)];
        $randomProfilePicturePath = $profilePicturesDirectory . $randomProfilePicture;
        
        if(file_exists($randomProfilePicturePath)) {
            header('Content-Type: image/jpeg');
            readfile($randomProfilePicturePath);
            exit;
        } else {
            $defaultProfilePicturePath = $profilePicturesDirectory . 'default.jpg';
            if(file_exists($defaultProfilePicturePath)) {
                header('Content-Type: image/jpeg');
                readfile($defaultProfilePicturePath);
                exit;
            } else {
                echo "Default profile picture not found.";
            }
        }
    }
} else {
    echo "No profile picture name provided.";
}
?>

