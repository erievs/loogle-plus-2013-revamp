
<?php
session_start();
if (!isset($_SESSION["username"])) {
    echo '<script>window.location.href = "../user/login.php";</script>';
    exit();
}

include("important/db.php");

$icon = "home";
?>

<?php
if(isset($_GET['trump'])) {
    echo '<link rel="stylesheet" href="assets/css/trump.css">';
}
?>
    
<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
  <meta name="author" content="Andras Barthazi - https://github.com/boogie - Nick aka NCP https://github.com/erievs" />
  <title>Loogle+</title>
  <link rel="stylesheet" href="./stylesheets/gplus.css" />
  <link rel="stylesheet" href="./stylesheets/jquery.tipsy.css" />
  <link rel="stylesheet" href="./stylesheets/2011index.css" />
</head>

<link rel="icon" 
type="image/webp" 
href="images/fav.webp" />

<body id="application">
  <div id="main" class="centered">

    <header>
      <ul id="menu">
        <li class="active"><a href="#">L+</a></li>
        <li><a href="#">Gmail</a></li>
        <li><a href="#">Calendar</a></li>
        <li><a href="#">Photos</a></li>
      </ul>
      <ul id="secondary">
        <li><a id="little-talks" href="#"></a></li>
        <li id="header-notifications"><a href="#" title="Notifications">0</a></li>
        <li><a href="#">Preferences</a></li>
      </ul>
    </header>

    <div id="top">
      <div class="container">
        <h1 id="site-logo">Loogle+</h1>
        <ul id="top-tabs">
          <li id="top-tab-home" class="active"><a href="#" title="Home" class="button left w-tip"><span>Home</span></a></li>
          <li id="top-tab-photos"><a href="#" title="Photos" class="button middle w-tip"><span>Photos</span></a></li>
          <li id="top-tab-profile"><a href="#" title="Profile" class="button middle w-tip"><span>Profile</span></a></li>
          <li id="top-tab-circles"><a href="#" title="Circles" class="button middle w-tip"><span>Circles</span></a></li>
          <li id="top-tab-games"><a href="#" title="Games" class="button right w-tip"><span>Games</span></a></li>
        </ul>
        <div id="top-search">
          <input id="top-search-input" class="focusable" placeholder="Find people" />
        </div>
      </div>
    </div>

    <div id="content">
      <div class="container">

        <nav>
          <ul>
            <li><a href="#">Welcome</a></li>
            <li class="active"><a href="#">Stream</a></li>
            <li><a href="#">Sparks</a></li>
          </ul>
        </nav>

        <section id="pane">
          <div class="block">
            <h2>Stream</h2>

            <div class="message-container">
              <textarea id="new-message" class="focusable b-autoheight" placeholder="Share what's new..."></textarea>
              <label for="file-upload" class="camera-icon">
                  <img id="image-message" src="./images/cam.png" alt="Camera Icon">
              </label>
              <input type="file" id="file-upload" style="display: none;">
          </div>



            <button id="bob-button" style="background: #55a644;">Share</button>

          </div>
          <div id="stream"></div> 
        </section>

     </div>
    </div>

  </div>
  <script src="javascripts/jquery.min.js"></script>
  <script src="javascripts/jquery.tipsy.js"></script>
  <script src="javascripts/jquery.autoheight.js"></script>
  <script src="javascripts/gplus.js"></script>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

  <script>

      $(document).ready(function() {

          $('#bob-button').hide();

          $('#new-message').on('input', function() {
              if ($(this).height() > 79) {
                 $('#bob-button').show();
                  console.log("Height is above 79px");
              }
          });
      });


    $(document).ready(function() {
      
        function fetchAndDisplayPosts() {
            $.ajax({
                url: '<?php echo $siteurl; ?>/apiv1/fetch_posts_api.php',
                type: 'GET',
                dataType: 'json',
                success: function(posts) {
                    displayPosts(posts);
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching posts:', error);
                }
            });
        }

        function fetchAndDisplayComments(postId, postElement) {
            $.ajax({
                url: '<?php echo $siteurl; ?>/apiv1/fetch_comments.php?id=' + postId,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        displayComments(postElement, response.comments);
                    } else {
                        console.error('Error fetching comments:', response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching comments:', error);
                }
            });
        }

        var username = "<?php echo $_SESSION["username"]; ?>";
        var message = username + "";

        document.getElementById("little-talks").innerHTML = message;


            
      function displayComments(postElement, comments) {
          var commentsHTML = '<div class="comments">';
          $.each(comments, function(index, comment) {
              commentsHTML += '<div class="comment">';
              commentsHTML += '<div class="comment-details">';
              commentsHTML += '<img src="<?php echo $siteurl; ?>/apiv1/fetch_pfp_api.php?name=' + comment.username + '" alt="Profile Picture" width="24" height="24">';
              commentsHTML += '<span class="username">' + comment.username + '</span>';
              commentsHTML += '<span class="comment-time">' + comment.comment_content + '</span>';
              commentsHTML += '</div>';
              commentsHTML += '<div class="comment-content">' + comment.comment_time + '</div>';
              commentsHTML += '</div>'; 
          });
          commentsHTML += '</div>'; 
          postElement.append(commentsHTML);
      }


        function displayPosts(posts) {
          var stream = $('#stream');
          stream.empty(); 
          var currentDate = new Date();
      
          $.each(posts, function(index, post) {
              var postDate = new Date(post.created_at);
              var timeDiff = currentDate - postDate;
              var postTimeHTML = '';

              if (currentDate.getDate() === postDate.getDate() && currentDate.getMonth() === postDate.getMonth() && currentDate.getFullYear() === postDate.getFullYear()) {
                  var hours = postDate.getHours();
                  var minutes = postDate.getMinutes();
                  var ampm = hours >= 12 ? 'PM' : 'AM';
                  hours = hours % 12;
                  hours = hours ? hours : 12; 
                  minutes = minutes < 10 ? '0' + minutes : minutes; 
                  postTimeHTML = hours + ':' + minutes + ampm;
              } else {
                  var seconds = Math.floor(timeDiff / 1000);
                  var minutes = Math.floor(seconds / 60);
                  var hours = Math.floor(minutes / 60);
                  var days = Math.floor(hours / 24);
                  if (days > 0) {
                      postTimeHTML = days + ' Day' + (days > 1 ? 's' : '') + ' Ago';
                  } else if (hours > 0) {
                      postTimeHTML = hours + ' Hour' + (hours > 1 ? 's' : '') + ' Ago';
                  } else if (minutes > 0) {
                      postTimeHTML = minutes + ' Minute' + (minutes > 1 ? 's' : '') + ' Ago';
                  } else {
                      postTimeHTML = seconds + ' Second' + (seconds > 1 ? 's' : '') + ' Ago';
                  }
            }

              var postHTML = '<div class="message block">' +
                  '<a href="" class="avatar">' +
                  '<img alt="' + post.username + '" src="<?php echo $siteurl; ?>/apiv1/fetch_pfp_api.php?name=' + post.username + '" width="48" height="48" />' +
                  '</a>' +
                  '<div class="meta">' +
                  '<a href="#" class="user">' + post.username + '</a>' +
                  '&nbsp;-&nbsp;' +
                  '<a href="#" class="when"><abbr class="timestamp" title="' + post.created_at + '">' + postTimeHTML + '</abbr></a>' +
                  '&nbsp;-&nbsp;' +
                  '<a href="#" class="to">' + 'Sharing Publicly' + '</a>' +
                  '</div>' +
                  '<div class="text">' +
                  post.content +
                  '</div>' +
                  '<div class="image">' +
                  '<img alt="" style="width: 100%;" src="' + post.image_url + '"></img>' + 
                  '</div>' +
                  '<div class="actions">' +
                  '<a href="#" class="comment-link">Comment</a>' +
                  '&nbsp;-&nbsp;' +
                  '<a href="#">Share</a>' +
                  '</div>' +
                  '<div class="comment-section" style="display: none;">' +
                  '<textarea class="comment-textarea" placeholder="Write your comment here"></textarea>' +
                  '<button class="comment-submit">Submit</button>' +
                  '</div>' +
                  '</div>';
                  
              var postElement = $(postHTML);
              stream.append(postElement);
              fetchAndDisplayComments(post.id, postElement);
                  });
              }
              fetchAndDisplayPosts();
          });

          $('#stream').on('click', '.comment-link', function(e) {
              e.preventDefault();
              $(this).siblings('.comment-section').toggle();
          });



          function smoothReload(delay) {
          $("body").fadeOut(delay, function() {
              history.replaceState({}, document.title, window.location.pathname);
              location.reload();
          });
          }

          $(document).ready(function() {
    $('#bob-button').click(function() {
        var message = $('#new-message').val();
        var username = "<?php echo $_SESSION["username"]; ?>"; 
        var data = {
            username: username,
            postContent: message
        };

        // Check if a file is selected
        var file = $('#file-upload').prop('files')[0];
        if (file) {
            var formData = new FormData();
            formData.append('postImage', file);

            // Append text data to FormData object
            for (var key in data) {
                formData.append(key, data[key]);
            }

            $.ajax({
                url: '<?php echo $siteurl; ?>/apiv1-internal/submit_post_api.php', 
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    smoothReload(500);
                    console.log(response);
                },
                error: function(xhr, status, error) {
                    smoothReload(750);
                    alert('Error sending post. Please try again.');
                    console.error(xhr.responseText);
                }
            });
        } else {
            // If no image is selected, send only text data
            $.ajax({
                url: '<?php echo $siteurl; ?>/apiv1-internal/submit_post_api.php', 
                type: 'POST',
                data: data,
                success: function(response) {
                    smoothReload(500);
                    console.log(response);
                },
                error: function(xhr, status, error) {
                    smoothReload(750);
                    alert('Error sending post. Please try again.');
                    console.error(xhr.responseText);
                }
            });
        }
    });
});


  </script>
</body>
</html>
