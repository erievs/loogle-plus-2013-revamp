<?php
session_start();
if (!isset($_SESSION['username'])) {
    echo '<script>window.location.href = "../user/login.php";</script>';
    exit; 
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <style>

@import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300&family=Roboto+Draft:wght@300&family=Helvetica&family=Arial&family=sans-serif&display=swap');
               .main-header {
            background: #fff;
            font-family: Roboto, RobotoDraft, Helvetica, Arial, sans-serif;
            height: 60px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 15px;
        }

        .main-header .logo {
            height: 40px;
        }

        .main-header .search-container {
            display: flex;
            align-items: center;
            margin-right: 58%;
        }

        .main-header .search-bar {
            margin-right: 10px;
            width: 463px;
            height: 30px;
            border: 1px solid #D0D0D0;
            box-shadow: 1px 1px 5px #F3F3F3;
            flex: 1;
            padding-left: 5px;
        }

        .main-header .search-text {
            font-weight: bold;
            cursor: pointer;
        }




        .sub-header {
            background: #f6f6f6;
            font-family: Roboto, RobotoDraft, Helvetica, Arial, sans-serif;
            height: 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 15px;
        }

        .sub-header .home-icon {
            margin-right: 5px;
        }

        .sub-header .divider {
            margin: 0 5px;
        }

        .sub-header .menu {
            display: flex;
            align-items: center;
        }

        .sub-header .menu .item {
            margin: 0 5px;
        }

        .sub-header .menu .more {
            position: relative;
        }

        .sub-header .more-dropdown {
            position: absolute;
            top: 100%;
            left: 0;
            display: none;
        }


        .sub-header .nav-tabs {
            padding: 0;
            margin: 0;
        }

        .sub-header .nav-tabs>li {
            margin: 0;
        }

        .sub-header .nav-tabs>li>a {
            border: none;
            border-radius: 0;
            padding: 10px 15px;
            color: #000;
        }

        .sub-header .nav-tabs>li.active>a {
            background: none;
            border: none;
            border-bottom: 3px solid #007bff;
            color: #007bff;
        }

        

        .sub-header .menu {
            display: flex;
            align-items: center;
            margin: 0 auto;
        }

        .logo {
            margin-right: 10px;
        }



        .post {
            background: #fff;
            border: 1px solid #d0d0d0;
            margin: 10px;
            padding: 15px;
            min-height: 250px;
            height: auto;
            box-sizing: border-box;
            width: 500px;
        }

        @media (max-width: 720px) {


            .container {

                width: 1073px;
            }
        }


        .container {
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            width: 1073px;
        }

        .column {
            flex: 0 0 calc(33.33% - 20px);
        }

        body {
            background: #e5e5e5;
        }

        @media (max-width: 1080px) {
            .column {
                flex: 0 0 calc(50% - 20px);
            }
        }

        @media (max-width: 720px) {
            .column {
                width: 1070px
            }
        }

        @media (min-width: 1591px) {
            .container {
                width: 1591px;
            }
        }

        .post-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 5px 0;
        }

        .username {
            font-weight: bold;
            color: #000;
        }

        .post-meta {
            color: #808080;
        }

        .upload-time {
            margin-left: 10px;
        }

        .post-content {
            margin: 5px 0;
            word-wrap: break-word;
            white-space: pre-wrap;
            line-height: 1.5;
        }
        .main-header .search-text {
            background: url(search.png) no-repeat;
            width: 62px;
            height: 30px;
            display: block;
            fill: none;
        }
        .nav-tabs>li>a {
            margin-right: 20px;
            line-height: 1.42857143;
            border: 1px solid transparent;
            border-radius: 4px 4px 0 0;
        }
        .container {
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .column {
            flex: 0 0 calc(33.33% - 20px);

            @media (max-width: 1600px) {
                flex: 0 0 calc(50% - 20px);
            }

            @media (max-width: 1200px) {

                flex: 0 0 calc(100% - 20px);
            }
        }
        .container {
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            flex-wrap: wrap;
        }

        .column {
            flex: 0 0 calc(50% - 20px);

            @media (max-width: 720px) {

                flex: 0 0 calc(100% - 20px);


            }


        }

        @media (max-width: 700px) {

            .container {

                width: 550px;
            }
        }

        .post-create {
            background: #f6f6f6;
            padding: 10px;
            margin: 10px;
            position: relative;
        }

        .post-create textarea {
            width: 100%;
            height: 100px;
            resize: none;
            border: none;
            outline: none;
            background: transparent;
        }

        .post-create-icons {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .post-create-icons img {
            width: 30px;
            height: 30px;
            cursor: pointer;
        }

        .post-create {
            background: #f6f6f6;
            padding: 10px;
            margin: 10px;
            position: relative;
            width: 500px;
            height: 250px;
        }

        .post-create {
            background: #f6f6f6;
            padding: 10px;
            margin: 10px;
            width: 500px;
            height: auto;
            position: relative;
        }

        #post-input {
            width: 100%;
            height: 250px;
            resize: none;
            border: none;
            outline: none;
            background: transparent;
        }

        .comment-box {
            background: #ffffff;
            display: none;
            padding: 10px;
            border-radius: 5px;
            position: relative;
            width: 100%;
        }

        .comment-box .triangle {
            position: absolute;
            width: 0;
            height: 0;
            border-style: solid;
            border-width: 0 8px 12px 8px;
            border-color: transparent transparent #ffffff transparent;
            top: -12px;
            left: 10px;
        }

        .comment-box .comment-text {
            font-weight: bold;
            margin: 10px 0;
        }

        .comment-box button {
            background: #007bff;
            color: #ffffff;
            border: none;
            border-radius: 5px;
            padding: 5px 10px;
            cursor: pointer;
            margin-right: 10px;
        }

        .comment-box button:last-child {
            background: #ccc;
        }

        .post-create-icons {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .post-create-icons img {
            width: 30px;
            height: 30px;
            cursor: pointer;
        }
        .post-create {
            background: #f6f6f6;
            padding: 10px;
            margin: 10px;
            width: 500px;
            height: auto;
            position: relative;
            height: 250px;
        }
        .image-write {
            background-image: url('assets/icons/astlas.png');
            background-position: -95px -144px;
            width: 25px;
            height: 18px;
            display: inline-block;
            vertical-align: middle;
            scale: 1.15;
        }
        .image-photo {
            background-image: url('assets/icons/astlas.png');
            background-position: -121px 200px;
            width: 25px;
            height: 18px;
            display: inline-block;
            vertical-align: middle;
            scale: 1.15;
        }
        .home-h-icon {
          background-image: url('assets/icons/astlas2.png');
          background-position: 0px 381px;
          width: 22px;
          height: 19px;
          display: inline-block;
          vertical-align: middle;
          scale: 0.85;
          margin-right: 5px;
          }
        .home-icon {
          margin-right: 5px;
          font-size: 13px;
          color: #939393;
          margin-top: 1px;
        }
        .arrow-icon {
         color: black;
         font-size: 13px;
         margin-top: 0px;
         margin-left: 1px;
        }
        .sidebar {
  position: fixed;
  top: 0;
  left: 0;
  width: 250px;
  height: 500px;
  background: #fff;
  z-index: 999;
  transform: translateX(-100%);
  transition: transform 0.3s ease-in-out;
  top: 60px;
  border: 0.25px solid #d0d0d0;
    border-top-color: rgb(208, 208, 208);
    border-top-style: solid;
    border-top-width: 0.25px;
  border-top: 0px solid #d0d0d0;
}

.sidebar ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.sidebar li {
    margin-bottom: 10px;
}

.sidebar .icon {
    font-size: 16px;
    color: #333;
    cursor: pointer;
}

.sticky-header {
    position: fixed;
    height: 40px;
    width: 100%;
    background: #fff;
    z-index: 999;
    display: none;
    transition: display 0.3s ease-in-out; /* You can adjust the duration as needed */
}

.sticky-header .home-icon {
    margin-right: 5px;
}

.sticky-header .divider {
    margin: 0 5px;
}

.sticky-header .menu {
    display: flex;
    align-items: center;
}

.sticky-header .menu .item {
    margin: 0 5px;
}

.sticky-header .menu .more {
    position: relative;
}

.sticky-header .more-dropdown {
    position: absolute;
    top: 100%;
    left: 0;
    display: none;
}

.sticky-header .nav-tabs {
    padding: 0;
    margin: 0;
}

.sticky-header .nav-tabs>li {
    margin: 0;
}

.sticky-header .nav-tabs>li>a {
    border: none;
    border-radius: 0;
    padding: 10px 15px;
    color: #000;
}

.sticky-header .nav-tabs>li.active>a {
    background: none;
    border: none;
    border-bottom: 3px solid #007bff;
    color: #007bff;
}

.sticky-header .menu {
    display: flex;
    align-items: center;
    margin: 0 auto;
}

.sticky-header .menu {
    display: flex;
    align-items: center;
    margin: 0 auto;

}

.post-image {
    width: 95%;
margin: 2.5% 0;
margin-left: 2.5%;
}
.container {
    padding: 15px;
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    flex-wrap: wrap;
}

.column {
    flex: 0 0 calc(33.33% - 20px);
    margin-bottom: 15px; /* Add margin at the bottom to separate the columns vertically */
    box-sizing: border-box;
}

@media (max-width: 720px) {
    .column {
        flex: 0 0 calc(100% - 20px); /* Full width on smaller screens */
    }
}
.container {
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .column {
            flex: 0 0 calc(33.33% - 20px);
        }

        @media (max-width: 1600px) {
            .column {
                flex: 0 0 calc(50% - 20px);
            }
        }

        @media (max-width: 720px) {
            .column {
                flex: 0 0 calc(100% - 20px);
            }
        }
        .write-post-expanded {
    display: none; /* Initially hide it */
    justify-content: center;
    align-items: center;
    height: 400px; /* Adjust the height as needed */
    transition: opacity 0.5s ease-in-out; /* Add a smooth transition effect */
}
.post-create textarea {
  width: 100%;
  height: 100px;
  resize: none;
  border: none;
  outline: none;
  background: #fff;
  color\#2f2b2b: !important;
  color: black;
  font-weight: bold;
  font-size: 14px;
  line-height: 3.5;
  margin-left: 12.5px;
}
.post-create {
  background: #f6f6f6;
  padding: 10px;
  margin: 10px;
  width: 500px;
  height: auto;
  position: relative;
  height: 200px;
  margin-top: 7px;
}
.post-create textarea {
  width: 95%;
  height: 100px;
  resize: none;
  border: none;
  outline: none;
  background: #fff;
  color\#2f2b2b: !important;
  color: black;
  font-weight: bold;
  font-size: 14px;
  line-height: 3.5;
  margin-left: 12px;
  margin-top: 8px;
}
.post-create textarea {
  width: 98%;
  height: 100px;
  resize: none;
  border: none;
  outline: none;
  background: #fff;
  color\#2f2b2b: !important;
  color: black;
  font-weight: bold;
  font-size: 14px;
  line-height: 3.5;
  margin-left: 4px;
  margin-top: 8px;
}

.image-write {
  background-image: url('assets/icons/astlas.png');
  background-position: -95px -144px;
  width: 25px;
  height: 18px;
  display: inline-block;
  vertical-align: middle;
  scale: 1.35;
}

.post-create-icons {   display: flex;   justify-content: left;   align-items: center;   margin-left: 30px;   gap: 37px;   marg-top: 18px;   margin-top: 15px;   line-height: 15px; }

.post-create textarea {
  width: 98%;
  height: 100px;
  resize: none;
  border: none;
  outline: none;
  background: #fff;
  color\#2f2b2b: !important;
  color: black;
  font-weight: bold;
  font-size: 16px;
  line-height: 3.5;
  margin-left: 4px;
  margin-top: 8px;
  color: Arial,sans-serif;
  font-size: Arial,sans-serif;
  font-family: Arial,sans-serif;
}

.post-create-icons {
  line-height: 15px;
  color: #8b8b8b;
}
.post-create-icons {
  line-height: 15px;
  color: #8b8b8b;
  font-size: 12px;
}
.post-create-icons {
  display: flex;
  justify-content: left;
  align-items: center;
  margin-left: 30px;
  gap: 37px;
  marg-top: 18px;
  margin-top: 15px;
  line-height: 15px;
  margin-top: 1;
  margin-top: 18px;
}


.pfp-write-post {
    width: 125px;
    height: 125px;
    overflow: hidden;
    border-radius: 50%; /* This makes the container round */
}

.round-image {
    width: 100%;
    height: 100%;
    object-fit: cover; /* This makes the image cover the entire container while maintaining its aspect ratio */
}

.pfp-write-post {
  width: 125px;
  height: 125px;
  overflow: hidden;
  border-radius: 50%;
  height: 10px;
  top: -110px;
  position: relative;
  top: 10px;
}

.post-create textarea {
  width: 98%;
  height: 100px;
  resize: none;
  border: none;
  outline: none;
  background: #fff;
  color\#2f2b2b: !important;
  color: black;
  font-weight: bold;
  font-size: 16px;
  line-height: 3.5;
  margin-left: 4px;
  margin-top: 8px;
  color: Arial,sans-serif;
  font-size: Arial,sans-serif;
  font-family: Arial,sans-serif;
  top: -100px;

}

.pfp-write-post {
  width: 100px;
  height: 125px;
  overflow: hidden;
  border-radius: 50%;
  height: 100px;
  top: -110px;
  position: relative;
  top: 10px;
  left: 100px;
}

.pfp-write-post {
  width: 100px;
  height: 125px;
  overflow: hidden;
  border-radius: 50%;
  height: 100px;
  top: -110px;
  position: relative;
  top: 10px;
  left: 18px;
  height: 100px;
}
.attach-photos-row {
    display: flex;
    align-items: center;
    margin-left: 60px
}

.attach, .photo-icon, .photo-text {
    margin-right: 10px; /* Add spacing between the elements */
}

.photo-icon {
    /* Add your photo icon background image here */
    background-color: #f0f0f0; /* Sample background color */
    padding: 10px; /* Adjust padding as needed */
    border-radius: 50%; /* Make it round */
}

.attach {
    font-weight: bold;
}

.photo-icon {
    /* You can add your photo icon as a background image here */
}

.photo-text {
  
}

.level-2 {
    display: none;
}

.write-post {
    height: 118px;
}
.photo-icon {

  padding: 10px;
  border-radius: 50%;
  background-image: url('assets/icons/astlas.png');
  background-position: -99px 166px;
  width: 20px;
  height: 20px;
}
.attach, .photo-icon, .photo-text {
  margin-right: 30px;
  font-size: 13px;
  margin-top: 9px;
}
.photo-icon {
  background-color: #f0f0f0;
  padding: 10px;
  border-radius: 50%;
  background-image: url('assets/icons/astlas.png');
  background-position: -99px 166px;
  width: 20px;
  height: 20px;
  scale: 1.075;
}
.photo-icon, .photo-text{
    font-size: 11px;
    margin-left: 10px;
}
.attach, .photo-icon, .photo-text {
    margin-left: 33px;
  font-size: 13px;
  margin-top: 9px;
}
.photo-icon, .photo-text {
  font-size: 11px;

  width: -4px;
}

.attach-photos-row {
    display: flex;
    align-items: center;
}

.attach, .photo-icon, .photo-text {
    margin-right: 20px; /* Increase the margin for more spacing */
}

.photo-icon {
    /* Add your photo icon background image here */
    background-color: #f0f0f0; /* Sample background color */
    padding: 10px; /* Adjust padding as needed */
    border-radius: 50%; /* Make it round */
}

.photo-icon {
    /* You can add your photo icon as a background image here */
}

.photo-text {
    font-weight: bold;
}
.attach, .photo-icon, .photo-text {
  margin-right: -29px;
}
.attach-photos-container {
    display: flex;
    flex-direction: column;
}

.attach-photos-row {
    display: flex;
    align-items: center;
}

.attach, .photo-icon, .photos {
    margin-right: 20px; /* Adjust spacing between elements */
}

.photo-icon {
    /* Add your photo icon styles here */
    background-color: #f0f0f0; /* Sample background color */
    padding: 10px; /* Adjust padding as needed */
    border-radius: 50%; /* Make it round */
}

.photo-text {
    font-weight: bold;
}
.attach-photos-row {
  display: flex;
  align-items: center;
  margin-left: 30px;
}

.attach, .photo-icon, .photos {
  margin-right: 0px;
}
.post-create textarea {
  width: 98%;
  height: 100px;
  resize: none;
  border: none;
  outline: none;
  background: #fff;
  color\#2f2b2b: !important;
  color: normal;
  font-weight: normal;
  font-size: 14px;
  line-height: 3.5;
  margin-left: 4px;
  margin-top: 8px;
  color: Arial,sans-serif;
  font-size: Arial,sans-serif;
  font-family: Arial,sans-serif;
  top: -100px;
}



.file-drop {
    display: flex;
    flex-direction: column;
    align-items: center;
    border: 2px dashed #ccc;
    text-align: center;
    padding: 20px;
}

.file-upload-button {
    padding: 10px 20px;
    border: 2px solid #b7b7b7;
    background-color: #b7b7b7;
    color: #fff;
    font-size: 16px;
    cursor: pointer;
}
.file-drop {
  display: flex;
  flex-direction: column;
  align-items: center;
  border: 2px black;
  text-align: center;
  padding: 20px;
  background-color: #e4e4e4;
}
.file-drop {
    display: none;
  text-align: center;
  width: 75%;
  left: 22.7%;
  position: relative;
  top: -10px;
}
.file-drop {
width: 0px;
  height: 0px;
  visibility: hidden;
}
.upload-button {
    background: #fff;
border: 1px black;
width: 250px;
height: 35px;
border: 1px solid rgba(10, 10, 10, 0.1);
text-align: center;
font-weight: bold;

}

.add-photos {
font-weight: bold;
font-size: 12px;
margin-right: 40px;


}

.level-3 {

  

    display: flex;
    
  align-items: center;
  
  margin-left: 30px;

  
}

.level-4 {
    background: #fff;
width: 134px;
height: 50px;
width: 650px;
left: -11px;
position: relative;
}

.level-3 {
  display: flex;
  align-items: center;
  margin-left: 30px;
  position: relative;
  top: -4px;
}
.level-4 {
    display: none;
    background: #fff;
}

.level-4 button {
    margin-right: 10px; /* Add spacing between the buttons */
    border: none;
    color: #fff;
    padding: 10px 20px;
    cursor: pointer;
}

.share-button {
    background: #55a644;
}

.cancel-button {
    background: #fbfbfb;
}

/* Style for green share button */
.green-share-button {
    background: #d4edcc;
    /* Add any other styles you need for this button */
}

/* Style for gray cancel button */
.gray-cancel-button {
    background: #747474;
    /* Add any other styles you need for this button */
}

.level-4 button {
  margin-right: 10px;
  border: none;
  color: #fff;
  padding: 10px 20px;
  cursor: pointer;
  background: #f0f0f0;
  border: 1px solid rgba(10, 10, 10, 0.1);
}
.level-4 button {
  margin-right: 10px;
  border: none;
  color: #fff;
  padding: 7px 20px;
    padding-top: 7px;
    padding-right: 20px;
    padding-bottom: 7px;
    padding-left: 20px;
  cursor: pointer;
  background: #f0f0f0;
  border: 1px solid rgba(10, 10, 10, 0.1);
  height: 33px;
  border-radius: 2px;
  text-align: center;
}

.cance-button {
    color: black;
}

.level-4 button {
  margin-right: 10px;
  border: none;
  color: #fff;
  padding: 7px 20px;
  cursor: pointer;
  background: #f0f0f0;
  border: 1px solid rgba(10, 10, 10, 0.1);
  height: 33px;
  border-radius: 2px;
  text-align: center;
  top: 8px;
  position: relative;
  left: 20px;
}

.level-4 button {
    margin-right: 10px;
    border: none;
    color: #fff;
    padding: 0px 20px;
    cursor: pointer;
    background: #f0f0f0;
    border: 1px solid rgba(10, 10, 10, 0.1);
    height: 33px;
    border-radius: 2px;
    text-align: center;
    top: 8px;
    position: relative;
    left: 20px;
}

</style>
</head>
<body>

<div class="sticky-header" style="display: none;">
    <div class="menu">
    <span id="open-sidebar-1" class="home-h-icon home-icon"></span>
        <span class="divider"></span>
        <ul class="nav nav-tabs">
            <li role="presentation" class="active"><a href="#">All</a></li>
            <li role-presentation"><a href="#">Family</a></li>
            <li role="presentation"><a href="#">Friends</a></li>
            <li role="presentation" class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
                   aria-expanded="false">
                    More <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="#">Option 1</a></li>
                    <li><a href="#">Option 2</a></li>
                    <li><a href="#">Option 3</a></li>
                </ul>
            </li>
        </ul>
    </div>
</div>

<div class="main-header">
    <img class="logo"
         src="https://media.discordapp.net/attachments/1151242578604326922/1165090139261902878/catull-loogle.png"
         alt="Logo">
    <div class="search-container">
        <input class="search-bar" type="text">
        <div class="search-text"></div>
    </div>
    <div class="username-header">Your Username</div>
</div>


<div class="sidebar">
    <ul>
        <li><span class="icon">Home</span></li>
        <li><span class="icon">Profile</span></li>
        <li><span class="icon">People</span></li>
        <li><span class="icon">Photos</span></li>
        <li><span class="icon">What's Hot</span></li>
        <li><span class="icon">Communities</span></li>
        <li><span class="icon">Events</span></li>
        <li><span class="icon">Settings</span></li>
    </ul>
</div>
<div class="sub-header">
<span id="open-sidebar" class="home-h-icon home-icon"></span>


    <span class="home-icon">Home </span>
    <span class="arrow-icon"> ></span>
    <div class="menu">
        <span class="divider"></span>
        <ul class="nav nav-tabs">
            <li role="presentation" class="active"><a href="#">All</a></li>
            <li role-presentation"><a href="#">Family</a></li>
            <li role="presentation"><a href="#">Friends</a></li>
            <li role="presentation" class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
                   aria-expanded="false">
                    More <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="#">Option 1</a></li>
                    <li><a href="#">Option 2</a></li>
                    <li><a href="#">Option 3</a></li>
                </ul>
            </li>
        </ul>
    </div>
</div>


<div class="write-post-expanded">

</div>


<div class="content">
    <div class="container" id="posts-container">
   
    </div>
</div>

<!-- Sticky header, add similar content as the main header for the sticky header -->


<script src="http://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>


<script>
$(document).ready(function () {
    var mainHeader = $(".main-header");
    var subHeader = $(".sub-header");
    var stickyHeader = $(".sticky-header");
    var sidebar = $(".sidebar");
    var offset = mainHeader.offset().top;
    var sidebarTopPosition = 60; // Default top position for the sidebar

    $(window).scroll(function () {
        var scrollTop = $(window).scrollTop();
        var mainHeaderHeight = mainHeader.height();
        var subHeaderHeight = subHeader.height();
        var totalHeaderHeight = mainHeaderHeight + subHeaderHeight;

        if (scrollTop >= offset + totalHeaderHeight) {
            stickyHeader.css('display', 'block');
            sidebarTopPosition = 40; // Adjust the top position of the sidebar
        } else {
            stickyHeader.css('display', 'none');
            sidebarTopPosition = 60; // Reset the top position of the sidebar
        }
        
        // Apply the updated top position to the sidebar
        sidebar.css('top', sidebarTopPosition + 'px');
    });
});

</script>
<script>
    function formatTime(timestamp) {
        const date = new Date(timestamp);
        return date.toLocaleString('en-US', { hour: 'numeric', minute: '2-digit', hour12: true });
    }
    function fetchPosts() {
    fetch('http://localhost:8080/apiv1/fetch_posts_api.php')
        .then(response => response.json())
        .then(data => {
            const postsContainer = document.getElementById('posts-container');

            // Clear the existing posts
            postsContainer.innerHTML = '';

            // Calculate the number of columns based on the screen width
// Calculate the number of columns based on the screen width
let numColumns = 3; // Default for screens wider than 1600px
const screenWidth = window.innerWidth;

if (screenWidth <= 1599) {
    numColumns = 2; // For screens between 720px and 1599px
} else if (screenWidth <= 720) {
    numColumns = 1; // For screens less than 720px
}

// Create column containers
const columns = [];
for (let i = 0; i < numColumns; i++) {
    const column = document.createElement('div');
    column.className = 'column';
    columns.push(column);
    postsContainer.appendChild(column);
}

            // Include the "Write Post" element
            const postCreate = document.createElement('div');
postCreate.className = 'post-create';
postCreate.innerHTML = `
    <div class="write-post">

    <div class="level-1">

    <div class="pfp-write-post" style="display: none;">
    <img src="assets/icons/default.jpg" alt="" class="round-image">
    </div>

    <textarea id="postTextArea" placeholder="  Share what's new..."></textarea>
        <div class="triangle"></div>
    </div>


    
    </div>

    <div id="fileDrop" class="file-drop"">

</div>

    
    <div class="level-2">

    <div class="attach-photos-row">
            <div class="attach">
                Attach:
            </div>
            <div class="photo-icon">
            <p style="position: relative;
top: -7px;
left: 15px;">Photos</p>
            </div>
      
    </div>

    <div class="level-3" style="display: none;">

    <div class="add-photos">
            Add Photos:
        </div>

        <input type="file" id="fileUploadInput" accept="image/*" style="display: none;">


        <input type="file" id="fileUploadInput" accept="image/*" style="display: none">
<button class="upload-button" id="openFileDialog">Upload from computer</button>

    </div>



    </div>
    <div class="post-create-icons">
        <div>
            <div class="image-write"></div>
            <br>
            <br>
            <span style="color: black; font-weight: bold;">Text</span>
        </div>
        |
        <div>
            <div class="image-photo"></div>
            <br>
            <br>
            <span>Photos</span>
        </div>
    </div>

    <div class="level-4" style="background: #fff;">
    <button class="share-button" style="background: #55a644;">Share</button>
    <button class="cancel-button"  id="cancelButton" style="background: #fbfbfb; color: black;">Cancel</button>
    </div>
`;


    // You can adjust the animation duration by using a setTimeout or requestAnimationFrame here if needed



    columns[0].appendChild(postCreate);

    $(document).ready(function () {
    let postCreateMoved = false; // Initialize a flag to track if the "Write Post" element has been moved

    $('#postTextArea').click(function () {
        // Check if the "Write Post" element has already been moved
        if (!postCreateMoved) {
            const $postCreate = $('.post-create'); // Select the "post-create" element
            const $writePostDiv = $('.write-post-expanded'); // Select the "write-post-expanded" container
            const $writePostImage = $('.pfp-write-post');
            const $writePostLevel2 = $('.level-2');
            const $writePostLeve3 = $('.level-3');
            const $writePostPhotoIcon = $('.photo-icon');
            const $addPhotostext = $('.add-photos');
            const $uploadButton = $('.upload-button');
            const $attach = $('.attach');
            const $photo = $('.photo-icon');
            const $level4 = $('.level-4');
            const $box = $('.fileDrop');

            // Get the position of the writePostDiv
            const destination = $writePostDiv.position();

            // Animate the movement of the postCreate div
            $postCreate.animate({
                left: destination.left,
                top: destination.top,
                opacity: 0
            }, 300, function () {
                // After animation, move the "Write Post" element to the "write-post-expanded" container
                $writePostDiv.append($postCreate);
                // Reset position and opacity
                $postCreate.css({
                    background: '#f6f6f6',
                    padding: '10px',
                    width: '650px',
                    height: '300px',
                    border: '1px solid rgba(10, 10, 10, 0.1)',
                    position: 'relative',
                    margin: '0 auto',
                    marginTop: '40px',
                    left: '0',
                    top: '0',
                    opacity: '1',
                    'box-shadow': '3px 0 33px 0px #000',
                });

                $('.post-create-icons').hide();
                // Reveal the writePostDiv
                $writePostDiv.show();
                $level4.show();
            });

            // Adjust the CSS for #postTextArea
            $('#postTextArea').css({
                width: '75%',
                left: '22%',
                position: 'relative',
                border: '1px solid rgba(10, 10, 10, 0.1)',
            });

            $level4.css({
                top: '90px'
            });

            $writePostImage.show();
            $writePostLevel2.show();
            $level4.show();
            $box.hide();

            // Mark the "Write Post" element as already moved
            postCreateMoved = true;

            // Log that the click event is triggered

            $writePostPhotoIcon.click(function () {
                // Toggle the visibility of the #fileDrop element when .photo-icon is clicked
                $("#fileDrop").toggle(function () {
                    if ($(this).is(":visible")) {
                        $postCreate.css({
                            height: '300px'
                        });

                        $addPhotostext.show();
                        $writePostLeve3.show();
                        $uploadButton.show();
                        $level4.show();
                        $box.hide();
                        $photo.css({
                            display: 'none'
                        });
                        $attach.css({
                            display: 'none'
                        });
                        $level4.css({
                            top: '0px'
                        });
                    } else {
                        $addPhotostext.css({
                            display: 'none'
                        });
                        $writePostLevel2.css({
                            height: '300px',
                            display: 'block'
                        });
                        $writePostLevel3.css({
                            display: 'none'
                        });
                        $level4.css({
                        top: '90px'
                    });
                    }
                });
            });

            
        
          

            // Event listener to close the #fileDrop div when clicking outside
            $(document).on('click', function (event) {
                if (!$(event.target).closest('#fileDrop').length && !$(event.target).is($writePostPhotoIcon) && !$(event.target).is($uploadButton) ) {
                    $("#fileDrop").hide();
                    $postCreate.css({
                        height: '300px' // Reset the height
                    });
                    $writePostLevel2.css({
                        height: 'auto',
                        display: 'block'
                    });
                    $photo.show();
                    $attach.show();
                    $addPhotostext.hide();
                    $uploadButton.hide();
                    $box.hide();
                    $level4.css({
                        top: '90px'
                    });
                }
            });
        }
    });

    $('#cancelButton').click(function () {
       
                    location.reload();
});

$('#fileDrop').on('dragover', function (e) {
        e.preventDefault();
        $(this).addClass('dragover'); // Add a visual indication of the drop zone
    });

    $('#fileDrop').on('dragleave', function (e) {
        e.preventDefault();
        $(this).removeClass('dragover'); // Remove the visual indication when not dragging
    });

    $('#fileDrop').on('drop', function (e) {
        e.preventDefault();
        $(this).removeClass('dragover'); // Remove the visual indication

        const files = e.originalEvent.dataTransfer.files;
        // Check if any files were dropped
        if (files.length > 0) {
            handleFiles(files);
        }
    });

    // Function to handle the dropped files (you can use this to process the files)
    function handleFiles(files) {
        for (const file of files) {
            const reader = new FileReader();
            reader.onload = function (e) {
                const imageData = e.target.result; // The data URL of the image
                // You can send the 'imageData' to your server or do other processing here
            };
            reader.readAsDataURL(file);
        }
    }


// Event listener for the "Upload from computer" button
$('#openFileDialog').click(function () {
    const fileInput = document.getElementById('fileUploadInput');
    fileInput.click(); // Trigger the file input click event
});

// Listen for a change in the file input
$('#fileUploadInput').change(function () {
    // Handle the selected file (e.g., display its name)
    const selectedFile = $(this)[0].files[0];
    if (selectedFile) {
        console.log('Selected file:', selectedFile.name);
    }
});


$('.share-button').click(function () {
    // Extract the data you want to send
    const postContent = $('#postTextArea').val();
    const username = '<?php echo isset($_SESSION["username"]) ? $_SESSION["username"] : "" ?>';

    // Check if there's post content or an image selected
    if (!postContent && $('#fileUploadInput')[0].files.length === 0) {
        // Display an error message or take appropriate action
        console.log('Please enter text or select an image before sharing.');
        return; // Prevent further execution
    }

    // Create a FormData object to send data, including the file
    const formData = new FormData();
    formData.append('username', username); // Include the username
    formData.append('postContent', postContent);

    // Append the file to the FormData if one was selected
    if ($('#fileUploadInput')[0].files.length > 0) {
        formData.append('postImage', $('#fileUploadInput')[0].files[0]);
    }

    // Use AJAX to send the data to your API endpoint
    $.ajax({
        type: 'POST',
        url: 'http://loogleplus.free.nf/apiv1-internal/submit_post_api.php', // Replace with the correct URL
        data: formData,
        processData: false, // Important for sending files
        contentType: false, // Important for sending files
        dataType: 'json',
        success: function (response) {
            location.reload();
            // Handle the response from your API
            if (response.status === 'success') {
                // Post was successfully submitted, you can perform actions accordingly
                console.log(response.message);
                location.reload(); // Reload the page or update the UI as needed
            } else {
                // An error occurred, handle the error message
                console.log(response.message);
            }
        },
        error: function (error) {
            // Handle AJAX request error
            console.log('Error:', error);
        }
    });
});




});


 // Loop through the fetched posts in reverse order (latest post first)
            let currentColumnIndex = 0;
            for (let i = 0; i < data.length; i++) {
                const post = data[i];
                const postElement = document.createElement('div');
                postElement.className = 'post';
                const formattedTime = formatTime(post.created_at);

                postElement.innerHTML = `
                  
 <div class="post-top">
                    <p class="username">${post.username}</p>
                </div>
                <div class="post-meta">
                    <span>Sharing Publicly &nbsp;</span>
                    <a style="  color: inherit;  text-decoration: none; "href="view_post.php?id=${post.id}"> <span class="upload-time">${formattedTime}</span> </a>
                </div>
                <p class="post-content">${post.content}</p>
                <img class="post-image" src="${post.image_url}" alt="">

                `;

                // Append the post to the current column
                columns[currentColumnIndex].appendChild(postElement);

                // Update the current column index
                currentColumnIndex = (currentColumnIndex + 1) % numColumns;
            }
        })
        .catch(error => {
            console.error('Error fetching posts:', error);
        });
}
// Fetch posts initially and then set up a timer to fetch posts every 5 seconds
fetchPosts();
setInterval(fetchPosts, 600000);

    

</script>

<script>
$(document).ready(function() {
    const sidebar = $('.sidebar');
    const openSidebarButton = $('#open-sidebar');
    let sidebarOpen = false;

    openSidebarButton.on('click', function() {
        if (!sidebarOpen) {
            sidebar.css('transform', 'translateX(0)');
            sidebarOpen = true;
        } else {
            sidebar.css('transform', 'translateX(-100%)');
            sidebarOpen = false;
        }
    });

    $(document).on('click', function(event) {
        if (sidebarOpen && !$(event.target).closest('.sidebar').length && event.target !== openSidebarButton[0]) {
            sidebar.css('transform', 'translateX(-100%)');
            sidebarOpen = false;
        }
    });
});


</script>


</body>
</html>
