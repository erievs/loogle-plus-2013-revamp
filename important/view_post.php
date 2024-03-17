<?php
// Retrieve the id parameter from the URL
$id = $_GET['id'];
?>

    
        <script type="text/javascript">
        // Pass the PHP $id to JavaScript
        var idFromPHP = <?php echo json_encode($id); ?>;

        // Now, you can use idFromPHP in your JavaScript code
        console.log(idFromPHP);
    </script>

    <html lang="en">

        <head>
            <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1">
                    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
                    <link rel="stylesheet" href="assets/css/post1.css">
      <style>
        @media (max-width: 1280px) {
    .container {
       
        scale: 0.85; /* Add scale property */
        margin-left: 6%; /* Add margin-left property */
    }
}

@media (min-width: 721px){
.container {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
  align-items: flex-start;
  padding: 10px;
  margin-left: 20%;
}
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
                                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"> More <span class="caret"></span>
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
                        <img class="logo" src="https://media.discordapp.net/attachments/1151242578604326922/1165090139261902878/catull-loogle.png" alt="Logo">
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
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"> More <span class="caret"></span>
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

                <div class="container">
                    <div class="user-card">
                        <div class="card-info">
                        <div class="user-pfp"></div>
                        <br>
                        <div class="username"></div>
                        </div>
                    </div>
                    <div class="post">
                        <div class="post-pfp"></div>
                        <div class="post-info">
                            <div class="post-username"></div>
                            <div class="post-metadata">N/A</div>
                        </div>
                        <div class="post-content"><p></p></div>
                        <img class="post-image" src="">
                    </div>
                </div>
            </div>
            <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

            <script>


                $(document).ready(function() {



                    var id = <?php echo json_encode($id); ?>;

                    $.ajax({
                        url: 'http://loogleplus.free.nf/apiv1/fetch_single_post.php?id=' + id,
                        type: 'GET',
                        dataType: 'json',
                        success: function (userData) {

                            const usernameElement = $(".username");
                            usernameElement.text(userData.username);

                            const userPfpElement = $(".user-pfp");
                            userPfpElement.css('background-image', `url(${assets / icons / pfp.png})`);

                            const postPfpElement = $(".post-pfp");
                            postPfpElement.css('background-image', `url(${userData.image_url})`);

                            const postMetadataElement = $(".post-metadata");
                            postMetadataElement.text("Placeholder - " + getRelativeTime(userData.created_at));
                        },
                        error: function () {
                            console.log('Error fetching user data.');
                        }
                    });
        });

                $(document).ready(function() {
 


                    var id = <?php echo json_encode($id); ?>;

                    $.ajax({
                        url: 'http://loogleplus.free.nf/apiv1/fetch_single_post.php?id=' + id,
                        type: 'GET',
                        dataType: 'json',
                        success: function (postData) {

                            const usernameElement = $(".username, .post-username");
                            usernameElement.text(postData.username);

                            const userPfpElement = $(".user-pfp");
                            userPfpElement.css('background-image', `url(${assets / icons / pfp.png})`);
                            const postPfpElement = $(".post-pfp");
                            postPfpElement.css('background-image', `url(${assets / icons / pfp.png})`);

                            const postMetadataElement = $(".post-metadata");
                            postMetadataElement.text("Placeholder - " + getRelativeTime(postData.created_at));

                            const postContentElement = $(".post-content");
                            postContentElement.text(postData.content);

                        },
                        error: function () {
                            console.log('Error fetching user and post data.');
                        }
                    });
        });

                function getFormattedTime(createdAt) {

    const postDate = new Date(createdAt);
                const currentDate = new Date();

                const timeDifference = currentDate - postDate;

                const daysDifference = Math.floor(timeDifference / (1000 * 60 * 60 * 24));
                const monthsDifference = (currentDate.getFullYear() - postDate.getFullYear()) * 12 + (currentDate.getMonth() - postDate.getMonth());

                if (daysDifference === 0) {
        const hours = postDate.getHours();
                const minutes = postDate.getMinutes();
        const amOrPm = hours >= 12 ? 'pm' : 'am';
        let formattedHours = hours > 12 ? hours - 12 : hours;
                if (formattedHours === 0) {
                    formattedHours = 12;
        }
                const formattedMinutes = minutes < 10 ? `0${minutes}` : minutes;
                return `Today ${formattedHours}:${formattedMinutes}${amOrPm}`;
    } else if (daysDifference === 1) {
        return 'Yesterday';
    } else if (monthsDifference < 1) {
        return `${daysDifference} Days Ago`;
    } else {
        return `${monthsDifference} Months Ago`;
    }
}

                $(document).ready(function() {


                    var id = <?php echo json_encode($id); ?>;

                    $.ajax({
                        url: 'http://loogleplus.free.nf/apiv1/fetch_single_post.php?id=' + id,
                        type: 'GET',
                        dataType: 'json',
                        success: function (postData) {

                            console.log(postData);

                            const usernameElement = $(".username, .post-username");
                            usernameElement.text(postData.username);

                            if (postData.image_url) {
                                const postImageElement = $(".post-image");
                                postImageElement.attr('src', postData.image_url);
                                postImageElement.show();
                            }
                        },
                        error: function () {
                            console.log('Error fetching user and post data.');
                        }
                    });
        });

                $(document).ready(function () {



                    var id = <?php echo json_encode($id); ?>;

                    $.ajax({
                        url: 'http://loogleplus.free.nf/apiv1/fetch_single_post.php?id=' + id,
                        type: 'GET',
                        dataType: 'json',
                        success: function (postData) {

                            console.log(postData);

                            const usernameElement = $(".username, .post-username");
                            usernameElement.text(postData.username);

                            if (postData.image_url) {
                                const postImageElement = $(".post-image");
                                postImageElement.attr('src', postData.image_url);
                                postImageElement.show();
                            }

                            if (postData.content) {
            const postContentDiv = $(".post-content");
            const pElement = postContentDiv.find('p'); // Find the <p> element inside the <div>
            pElement.text(postData.content); // Set the text content of the <p> element
            postContentDiv.show();
        }

                            const postMetadataElement = $(".post-metadata");
                            postMetadataElement.text("Placeholder - " + getFormattedTime(postData.created_at));
                        },
                        error: function () {
                            console.log('Error fetching user and post data.');
                        }
                    });
});

            </script>
            <script>

                <script>
                    <script>
                        $(document).ready(function () {
    var mainHeader = $(".main-header");
                        var subHeader = $(".sub-header");
                        var stickyHeader = $(".sticky-header");
                        var sidebar = $(".sidebar");
                        var offset = mainHeader.offset().top;
                        var sidebarTopPosition = 60; 

                        $(window).scroll(function () {
        var scrollTop = $(window).scrollTop();
                        var mainHeaderHeight = mainHeader.height();
                        var subHeaderHeight = subHeader.height();
                        var totalHeaderHeight = mainHeaderHeight + subHeaderHeight;

        if (scrollTop >= offset + totalHeaderHeight) {
                            stickyHeader.css('display', 'block');
                        sidebarTopPosition = 40; 
        } else {
                            stickyHeader.css('display', 'none');
                        sidebarTopPosition = 60; 
        }

                        sidebar.css('top', sidebarTopPosition + 'px');
    });
});
                    </script>
                    <script>
                    </script>
                    <script>
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
                        $(document).ready(function() {
            const sidebar = $('.sidebar');
                        const openSidebarButton = $('#open-sidebar-1');
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
                    <script>

                    </script>
                </body>

</html>
