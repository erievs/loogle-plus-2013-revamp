<meta>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

</meta>

<style>
.footer,.sidebar{position:fixed;left:0}.timestamp-right{float:right;text-align:right;font-family:'Product Sans',sans-serif;color:#b0b0b0}.post{width:80%;outline:0;margin:20px 0;padding-right:0;padding-left:0;background-color:#fff;max-height:none;overflow-y:auto;box-shadow:0 0 5px rgba(0,0,0,.1)}.container{background-color:#eceff1}.footer{padding-top:20px;height:7.5%;background-color:#000;color:#000;bottom:0;width:100%}.footer-button{color:#fff;text-decoration:none;font-weight:700;display:flex;align-items:center;justify-content:center;height:50px}.sidebar{width:0;height:100%;top:0;background-color:#fffF;overflow-x:hidden;transition:.5s;z-index:1}.sidebar-content{padding:20px;color:#fff}.image-username-container{position:relative}.profile-image{width:100%;height:auto}.username-overlay{position:absolute;bottom:0;left:0;right:0;top:66.66%;padding-left:10%;margin:0;color:#fff}
</style>


<?php include("ui/elements/home/util/home_startup.php"); ?>


<?php include("ui/elements/home/util/display_posts.php"); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loogle+</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/materialize.min.css">
    <link rel="stylesheet" href="https://egkoppel.github.io/product-sans/google-fonts.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/mobileindex1.css">
    <style>
     .sidebar{width:0;height:100%;position:fixed;top:0;left:0;background-color:#fffF;overflow-x:hidden;transition:.5s;z-index:1}.sidebar-content{padding:20px}.container{top:-60px;position:relative}.content{margin-left:0;transition:.5s;z-index:2}.content.opened{margin-left:66.66%}.popup-menu{color:#000;display:none;position:absolute;background-color:#fff;border:1px solid #ccc;box-shadow:0 2px 4px rgba(0,0,0,.2);z-index:1;right:0;top:100%}.post-button,.post-button:hover{background-color:#b83224}.fixed-post-button,.post-button{position:fixed;bottom:20px;right:20px}.popup-menu ul{list-style-type:none;padding:0}.popup-menu li{padding:10px;text-align:center}.popup-menu a{text-decoration:none;color:#333;display:flex;align-items:center}.popup-menu i.material-icons{font-size:24px;margin-right:10px}.popup-menu a:hover{background-color:#eee}.menu-icon{cursor:pointer}.show-popup-menu{display:block}.post-button{top:80%;color:#fff;border-radius:50%;width:50px;height:50px;z-index:999}.sidebar-content,.username{color:#000}.sidebar img{width:100%;height:20%}.footer{background-color:#333;padding-top:4px}.footer i.material-icons{top:-10px;padding-top:3px;font-size:20px}.footer p{font-size:14px}.username{font-weight:700}
    </style>
</head>
<body>  

<?php include("ui/elements/home/header_and_posts.php"); ?>

<?php include("ui/elements/home/write_post.php"); ?>

<?php include("ui/elements/home/hambuger_menu.php"); ?>

<?php include("ui/elements/home/bottom_nav.php"); ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {

    });
</script>
<script>
$(document).ready(function(){let e=$("#open-popup-menu"),p=$("#popup-menu");e.click(function(){p.toggleClass("show-popup-menu")}),$(document).click(function(n){p.is(n.target)||e.is(n.target)||0!==p.has(n.target).length||p.removeClass("show-popup-menu")})});
</script>
<script>
document.addEventListener("DOMContentLoaded",function(){let e=document.getElementById("menu-icon"),t=document.getElementById("sidebar"),n=document.getElementById("main-content"),d=!1;e.addEventListener("click",()=>{d?(t.style.width="0",n.style.marginLeft="0",d=!1):(t.style.width="66.66%",d=!0)})}),document.addEventListener("DOMContentLoaded",function(){let e=document.getElementById("menu-icon"),t=document.getElementById("sidebar"),n=document.getElementById("main-content"),d=!1;e.addEventListener("click",()=>{d?l():(t.style.width="66.66%",d=!0)});let i=!1;function l(){t.style.width="0",n.style.marginLeft="0",d=!1}e.addEventListener("click",()=>{i=!1,setTimeout(()=>{i=!0},0)}),document.addEventListener("click",n=>{i&&d&&!t.contains(n.target)&&n.target!==e&&l()})});
</script>
<script>
document.addEventListener("DOMContentLoaded",function(){document.getElementById("pleasegodwork").addEventListener("click",function(){location.reload()})});
</script>
<script>
document.addEventListener("DOMContentLoaded",function(){var e=document.getElementById("linkModal"),t=document.getElementById("openLinkModal"),n=document.getElementById("cancelLinkButton"),l=document.getElementById("insertLinkInput"),d=document.getElementById("insertLinkButton");M.Modal.init(document.getElementById("write-post-modal"),{});var i=M.Modal.init(e);t.addEventListener("click",()=>i.open()),n.addEventListener("click",()=>{i.close(),l.value=""}),d.addEventListener("click",()=>{document.getElementsByName("postLink")[0].value=l.value,i.close(),l.value=""})});
</script>
<script>
var path=window.location.pathname,page=path.split("/").pop(),menuItems=document.querySelectorAll(".menu-item");menuItems.forEach(function(e){e.getAttribute("href")===page&&e.classList.add("active")});
</script>

<style>
    .active {
        background-color: #e0e0e0; 
        color: #333; 
    }
</style>
<script>
<script>
document.addEventListener("DOMContentLoaded",function(){var t=document.getElementById("postContent"),e=M.Modal.init(document.getElementById("write-post-modal"),{});t.addEventListener("input",function(){""!==t.value.trim()&&e.open()})});
</script>

</script>
<script>
document.addEventListener("DOMContentLoaded",function(){var e=document.querySelectorAll(".modal");M.Modal.init(e),document.querySelector(".post-input").addEventListener("focus",function(){M.Modal.getInstance(document.getElementById("write-post-modal")).open()})});

</script>
<script>
document.addEventListener("DOMContentLoaded",function(){var t=document.getElementById("postContent"),e=M.Modal.init(document.getElementById("write-post-modal"),{});t.addEventListener("click",function(){e.open()})});
    </script>

</body>
</html>