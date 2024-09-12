<?php
session_start();
include("important/db.php");

if (!isset($_SESSION["username"])) {
  header("Location: ../user/login.php");
  exit();
}

$username = $_GET['username'];

$icon = "photos";
?>

<?php
if (isset($_GET['trump'])) {
    echo '<link rel="stylesheet" href="assets/css/trump.css">';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loogle Photos</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <link rel="stylesheet" href="assets/css/2013isamess.css">
    <link rel="stylesheet" href="assets/css/2013indexres.css">
    <link rel="stylesheet" href="assets/css/2013notes.css">
    <link rel="stylesheet" href="assets/css/univesalcoolstuff.css">
    <link rel="stylesheet" href="assets/css/headerfix.css">
    <link rel="stylesheet" href="assets/css/2013profile_headerfix.css">
    <link rel="stylesheet" href="assets/css/2013photos.css">
</head>
<body>

    <?php require_once("inc/topstuffs.php") ?>

    <div class="container" id="imagesContainer"></div>

    <script>
        $(document).ready(function() {
            function fetchImages() {
                const username = encodeURIComponent("<?php echo $username ?>");
                $.getJSON("<?php echo $siteurl ?>/apiv1/fetch_photos.php?username=" + username, function(data) {
                    if (data && data.length > 0) {
                        let gallerySection = '<div class="gallery-section">' + '<div class="gallery">';
                        $.each(data, function(index, image) {

                            const sanitizedUrl = $('<div>').text(image.url).html(); 
                            gallerySection += '<div class="col-md-3">' +
                                               '<div class="thumbnail">' +
                                                 '<img src="' + sanitizedUrl + '" alt="Image">' +
                                               '</div>' +
                                             '</div>';
                        });
                        gallerySection += '</div></div>';
                        $("#imagesContainer").html(gallerySection);
                    } else {
                        $("#imagesContainer").html('<div class="col-md-12 text-center error-message"><p>No images found.</p></div>');
                    }
                }).fail(function() {
                    $("#imagesContainer").html('<div class="col-md-12 text-center error-message"><p>Failed to fetch images. Please try again later.</p></div>');
                });
            }
            fetchImages();
        });
    </script>

    <script>
        $(document).ready(function() {
            const sidebar = $('.sidebar'); 
            const openSidebarButton = $('.photo-p-icon'); 
            let sidebarOpen = false;

            openSidebarButton.on('click', function() {
                sidebarOpen = !sidebarOpen;
                sidebar.css('transform', sidebarOpen ? 'translateX(0)' : 'translateX(-100%)');
            });

            $(document).on('click', function(event) {
                if (sidebarOpen && !$(event.target).closest('.sidebar').length && !$(event.target).is(openSidebarButton)) {
                    sidebar.css('transform', 'translateX(-100%)');
                    sidebarOpen = false;
                }
            });
        });
    </script>

</body>
</html>