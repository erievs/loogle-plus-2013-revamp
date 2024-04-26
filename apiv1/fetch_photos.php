<?php

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

// Include database configuration
include("../important/db.php");

function getImagesFromDatabase() {
    global $siteurl, $db_host, $db_user, $db_pass, $db_name;
    
    if (!isset($_GET['username'])) {
        http_response_code(400);
        return json_encode(array('error' => 'No username provided'));
    }
    
    $username = $_GET['username'];
    
    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch banner and profile picture URL placeholders
    $banner_url = null;
    $profile_picture_url = null;

    // Check if banner exists for the given username
    $banner_extensions = ['.jpg', '.webp', '.png'];
    foreach ($banner_extensions as $extension) {
        $banner_path = "../assets/banners/{$username}{$extension}";
        if (file_exists($banner_path)) {
            $banner_url = "{$siteurl}/assets/banners/{$username}{$extension}";
            break;
        }
    }

    // Check if profile picture exists for the given username
    $profile_picture_extensions = ['.jpg', '.webp', '.png'];
    foreach ($profile_picture_extensions as $extension) {
        $profile_picture_path = "../assets/profilepictures/{$username}{$extension}";
        if (file_exists($profile_picture_path)) {
            $profile_picture_url = "{$siteurl}/assets/profilepictures/{$username}{$extension}";
            break;
        }
    }

    // Fetch image URLs and created_at from the database
    $query = "SELECT image_url, created_at FROM posts WHERE username = '$username' AND image_url IS NOT NULL ORDER BY created_at DESC";
    $result = $conn->query($query);
    $images = array();

    if ($result->num_rows > 0) {
        while ($post = $result->fetch_assoc()) {
            // Construct image URL for the post
            $image_url = $siteurl . str_replace('..', '', $post['image_url']);

            // Add created_at to the image data
            $image_data = array(
                'url' => $image_url,
                'created_at' => $post['created_at']
            );

            $images[] = $image_data;
        }
    }

    $conn->close();

    // Add banner and profile picture URLs if they exist
    if ($banner_url !== null) {
        $banner_data = array(
            'url' => $banner_url,
            'created_at' => filemtime($banner_path) // Get the file modification time
        );
        $images[] = $banner_data;
    }
    if ($profile_picture_url !== null) {
        $profile_picture_data = array(
            'url' => $profile_picture_url,
            'created_at' => filemtime($profile_picture_path) // Get the file modification time
        );
        $images[] = $profile_picture_data;
    }

    return $images;
}


$imagesData = getImagesFromDatabase();
echo json_encode($imagesData);
?>
