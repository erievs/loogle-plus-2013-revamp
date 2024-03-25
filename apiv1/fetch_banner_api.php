<?php
if(isset($_GET['name'])) {
    $bannerName = $_GET['name'];
    $bannersDirectory = '../assets/banners/';
    $bannerFilePath = $bannersDirectory . $bannerName;
    if(file_exists($bannerFilePath)) {
        header('Content-Type: image/png'); 
        readfile($bannerFilePath);
        exit;
    } else {
        $defaultBannerPath = $bannersDirectory . 'default.png';
        if(file_exists($defaultBannerPath)) {
            header('Content-Type: image/png');
            readfile($defaultBannerPath);
            exit;
        } else {
            echo "Default banner not found.";
        }
    }
} else {
    echo "No banner name provided.";
}
?>
