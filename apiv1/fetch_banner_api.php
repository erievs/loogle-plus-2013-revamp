<?php
if(isset($_GET['name'])) {
    $bannerName = $_GET['name'];
    $bannersDirectory = '../assets/banners/';
    $bannerFilePath = $bannersDirectory . $bannerName . ".jpg";
    if(file_exists($bannerFilePath)) {
        header('Content-Type: image/jpeg'); 
        readfile($bannerFilePath);
        exit;
    } else {
        $defaultBannerPath = $bannersDirectory . 'default.jpg';
        if(file_exists($defaultBannerPath)) {
            header('Content-Type: image/jpeg');
            readfile($defaultBannerPath);
            exit;
        } else {
            $defaultBannerPaths = array(
                $bannersDirectory . 'default1.jpg',
                $bannersDirectory . 'default2.jpg',
                $bannersDirectory . 'default3.jpg',
                $bannersDirectory . 'default4.jpg'
            );

            shuffle($defaultBannerPaths);
            $foundDefaultBanner = false;
            foreach ($defaultBannerPaths as $defaultBanner) {
                if (file_exists($defaultBanner)) {
                    header('Content-Type: image/jpeg');
                    readfile($defaultBanner);
                    $foundDefaultBanner = true;
                    exit;
                }
            }
            if (!$foundDefaultBanner) {
                header('Content-Type: text/plain');
                echo "Default banner not found.";
                exit;
            }
        }
    }
} else {
    header('Content-Type: text/plain');
    echo "No banner name provided.";
    exit;
}
?>
