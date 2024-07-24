
<?php
session_start();
if (!isset($_SESSION["username"])) {
    echo '<script>window.location.href = "../user/login.php";</script>';
    exit();
}

include("../important/db.php");

$username = $_SESSION["username"];
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$stmt = $conn->prepare("SELECT username FROM moderators WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows == 0) {
    echo '<script>window.location.href = "../errors/403.php";</script>';
    exit();
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moderator Panel</title>
    <link rel="stylesheet" href="https://kspc.serv00.net/assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://kspc.serv00.net/assets/css/writepost.css" />
    <link rel="stylesheet" href="https://kspc.serv00.net/assets/css/headerfix.css" />
    <link rel="stylesheet" href="https://kspc.serv00.net/assets/css/univesalcoolstuff.css" />
    <link rel="stylesheet" href="https://kspc.serv00.net/assets/css/2013notes.css" />
    <link rel="stylesheet" href="https://kspc.serv00.net/assets/css/2013indexres.css" />
    <link rel="stylesheet" href="https://kspc.serv00.net/assets/css/2013isamess.css" />
    <style>
        .content {
            display: flex;
            flex-wrap: wrap;
            margin-top: 5%;
            margin-left: 10%;
        }

        #posts-list {
            overflow: scroll;
            height: 220px;
        }

        #ip-list {
            overflow: scroll;
            height: 400px;
        }


        #postTextArea {
            text-indent: 0.5ch; 
        }


    </style>
</head>
<body>
    <div class="content">
        
        <div class="post-create" style="height: 200px; width: 100px;">
            <div class="write-post">
                <h4>Welcome!</h4>
                <h5>Moderator:</h5>
                <p><?php echo $_SESSION["username"]; ?></p>
                <p style="font-size: 12px;">The Current Time Is</p> 
                <small id="current-time"></small>
                <p id="time-zone-thingy">()</P>
            </div>
        </div>

        
        <div class="post-create" style="height: 300px;">
            <div class="write-post">
                <h3 class="username" style="margin-left: 4px;">Mass Notifications</h3>
                <p class="username" style="margin-left: 4px;">Content</p>
                <textarea class="contentTextArea" id="postTextArea" placeholder="Notification content.."></textarea>

                <p class="username" style="margin-left: 4px; margin-top: 8px;">Sender</p>
                <textarea class="senderTextArea" id="postTextArea" placeholder="Sent by.." style="height: 25px;"></textarea>
                <button
                    class="share-button" id="sendNotificationButton"
                    style="background-image: -webkit-linear-gradient(top, #4d90fe, #4787ed); border: 1px solid #3079ed; border-radius: 2px; background-color: #4d90fe; margin-top: 5px; color: white; margin-left: 4px;"
                >
                    Send Notification
                </button>
            </div>
        </div>

        
        <div class="post-create" style="height: 400px;">
            <div class="write-post">
                <h3 class="username" style="margin-left: 4px;">Ban User</h3>
                <p class="username" style="margin-left: 4px;">User</p>

                <textarea class="banUser" id="postTextArea" placeholder="User123" style="height: 25px;"></textarea>

                <hr>

                <p class="username" style="margin-left: 4px;">IP Address</p>
                <textarea class="ipAdress" id="postTextArea" placeholder="Leave blank for a non IP ban" style="height: 25px;"></textarea>

                <p class="username" style="margin-left: 4px; margin-top: 8px;">Reason</p>
                <textarea class="banReason" id="postTextArea" placeholder="Harassment/Bullying"></textarea>
                <button
                    class="share-button" id="banUserButton"
                    style="background-image: -webkit-linear-gradient(top, #fe4d4d, #ed4747); border: 1px solid #ed3030; border-radius: 2px; background-color: #fe4d4d; margin-top: 5px; color: white; margin-left: 4px;"
                >
                    Ban User
                </button>
            </div>
        </div>

        
        <div class="post-create" style="height: 475px; width: 325px;">
            <h3 class="username" style="margin-left: 4px;">IP Log</h3>
            <div class="write-post">
                <div id="ip-list" class="write-post">
                
                </div>
            </div>
        </div>

    <!-- AHHHHHHHHHHHHHHHH KHAMLA HARIS IS EVERYWHERE -->
        
        <div class="post-create" style="width: 36%; height: 300px;">
            <h3 class="username" style="margin-left: 4px;">Posts</h3>
            <div id="posts-list" class="write-post">
            </div>
        </div>

        <div class="post-create" style="height: 375px;">
            <div class="write-post">
                <h3 class="username" style="margin-left: 4px;">Targeted Notification</h3>
                <p class="username" style="margin-left: 4px;">Content</p>
                
                <textarea class="contentTextAreaTag" id="postTextArea" placeholder="Notification content.."></textarea>

                <p class="username" style="margin-left: 4px; margin-top: 8px;">Sender</p>
                <textarea class="senderTextAreaTag" id="postTextArea" placeholder="Sent by.." style="height: 25px;"></textarea>


                <p class="username" style="margin-left: 4px; margin-top: 8px;">Recipent</p>
                <textarea class="recipentTextAreaTag" id="postTextArea" placeholder="Send to.." style="height: 25px;"></textarea>

                <button
                    class="share-button" id="sendNotificationButtonTag"
                    style="background-image: -webkit-linear-gradient(top, #4d90fe, #4787ed); border: 1px solid #3079ed; border-radius: 2px; background-color: #4d90fe; margin-top: 5px; color: white; margin-left: 4px;"
                >
                    Send Notification
                </button>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>

        $(document).ready(function() {

            function updateTime() {

                var userTimeZone = Intl.DateTimeFormat().resolvedOptions().timeZone;

                $('#user-timezone').text(userTimeZone);

                var timeZoneAbbr = new Intl.DateTimeFormat('en-US', { timeZone: userTimeZone, timeZoneName: 'short' }).format(new Date());

                $('#time-zone-thingy').text('(' + timeZoneAbbr.split(' ').pop() + ')');

                var options = { timeZone: userTimeZone, hour: '2-digit', minute: '2-digit', second: '2-digit' };
                var now = new Intl.DateTimeFormat('en-US', options).format(new Date());
                $('#current-time').text(now);
            }

            setInterval(updateTime, 1000);
            updateTime();

        });

        $(document).ready(function() {

           function loadPosts() {
               $.ajax({
                   url: '<?php echo $siteurl; ?>/apiv1/fetch_posts_api.php',
                   method: 'GET',
                   dataType: 'json',
                   success: function(data) {
                       let postsHtml = '';
                       $.each(data, function(index, post) {
                           postsHtml += `<p>${post.username} - ${post.content}</p>`;
                       });
                       $('#posts-list').html(postsHtml);
                   },
                   error: function(xhr, status, error) {
                       console.error('Failed to load posts:', error);
                       $('#posts-list').html('<p>Failed to load posts.</p>');
                   }
               });
           }

           loadPosts();


           function loadIPs() {
               $.ajax({
                   url: '<?php echo $siteurl; ?>/apiv1-internal/fetch_ips.php',
                   method: 'GET',
                   dataType: 'json',
                   success: function(data) {
                       let ipsHtml = '';
                       $.each(data, function(index, ip) {
                           ipsHtml += `<p>${ip.username} - ${ip.ip_address}</p>`;
                       });
                       $('#ip-list').html(ipsHtml);
                   },
                   error: function(xhr, status, error) {
                       console.error('Failed to load IP addresses:', error);
                       $('#ip-list').html('<p>Failed to load IP addresses.</p>');
                   }
               });
           }

           loadIPs();

       });

       $(document).ready(function() {
           $('#sendNotificationButton').on('click', function() {

               var content = $('.contentTextArea').val();
               var sender = $('.senderTextArea').val();

               if ($.trim(content) === '' || $.trim(sender) === '') {
                   alert('Both content and sender are required.');
                   return;
               }

               $.ajax({
                   url: '<?php echo $siteurl; ?>/apiv1-internal/mass_not_send.php',
                   type: 'POST',
                   data: {
                       content: content,
                       sender: sender
                   },
                   success: function(response) {
                       alert(response);
                   },
                   error: function(xhr, status, error) {
                       console.error('Error:', error);
                       alert('An error occurred. Please try again.');
                   }
               });
           });
       });

       $(document).ready(function() {
        $('#sendNotificationButtonTag').on('click', function() {

           var content = $('.contentTextAreaTag').val();
           var sender = $('.senderTextAreaTag').val();
           var recipient = $('.recipentTextAreaTag').val();


           $.ajax({
               url: '<?php echo $siteurl; ?>/apiv1-internal/not_send.php',
               type: 'POST',
               data: {
                   content: content,
                   sender: sender,
                   recipient: recipient
               },
               success: function(response) {
                   alert(response);
               },
               error: function(xhr, status, error) {
                   console.error('Error:', error);
                   alert('An error occurred. Please try again.');
               }
           });
       });
       });

       $(document).ready(function() {

        $('#banUserButton').on('click', function() {
            
            var userToBan = $('.banUser').val();
            var ipAddress = $('.ipAdress').val();
            var reason = $('.banReason').val();

            if ($.trim(userToBan) === '' || $.trim(reason) === '') {
                alert('User and reason are required.');
                return;
            }

            $.ajax({
                url: '<?php echo $siteurl; ?>/apiv1-internal/ban_user.php',
                type: 'POST',
                data: {
                    mod_username: '<?php echo $_SESSION["username"];?>',
                    user_to_ban: userToBan,
                    ip_address: ipAddress || 'non ip ban', 
                    reason: reason
                },
                success: function(response) {
                    alert(response);
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    alert('An error occurred. Please try again.');
                }
            });
        });
    });


    </script>
</body>
</html>