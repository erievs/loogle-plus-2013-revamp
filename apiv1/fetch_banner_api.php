<?php
if(isset($_GET['name'])) {
    $bannerName = $_GET['name'];
    $bannersDirectory = '../assets/banners/';

    $allowedExtensions = array('jpg', 'jpeg', 'png', 'webp');

    $foundBanner = false;
    foreach ($allowedExtensions as $extension) {
        $bannerFilePath = $bannersDirectory . $bannerName . ".$extension";
        if(file_exists($bannerFilePath)) {
            $mimeType = mime_content_type($bannerFilePath);
            header("Content-Type: $mimeType"); 
            readfile($bannerFilePath);
            $foundBanner = true;
            exit;
        }
    }

    if (!$foundBanner) {
        $defaultBanners = array(
            $bannersDirectory . 'default1.jpg',
            $bannersDirectory . 'default2.jpg',
            $bannersDirectory . 'default3.jpg',
            $bannersDirectory . 'default4.jpg'
        );

        shuffle($defaultBanners);

        foreach ($defaultBanners as $defaultBanner) {
            $extension = pathinfo($defaultBanner, PATHINFO_EXTENSION);
            if (in_array($extension, $allowedExtensions) && file_exists($defaultBanner)) {
                $mimeType = mime_content_type($defaultBanner);
                header("Content-Type: $mimeType");
                readfile($defaultBanner);
                exit;
            }
        }

        header('Content-Type: text/plain');
        echo "Default banner not found.";
        exit;
    }
} else {
    header('Content-Type: text/plain');
    echo "No banner name provided.";
    exit;
}
?>
