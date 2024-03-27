<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Send Notification</title>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h2>1984 Panel</h2>
    <form id="notificationForm">
        <label for="content">Content:</label><br>
        <textarea id="content" name="content" rows="4" cols="50"></textarea><br>
        <label for="sender">Sender:</label><br> <!-- Add a label for the sender input -->
        <input type="text" id="sender" name="sender"><br> <!-- Add an input field for the sender -->
        <input type="submit" value="Send Notification">
    </form>

    <script>
    $(document).ready(function() {

        $("#notificationForm").submit(function(event) {
            event.preventDefault(); 

            var content = $("#content").val();
            var sender = $("#sender").val(); // Get the sender value from the input field

            $.ajax({
                type: "POST",
                url: "http://localhost:8090/apiv1/coolapi.php",
                data: {
                    content: content,
                    sender: sender // Pass the sender along with content
                },
                success: function(response) {
                    alert(response);
                },
                error: function(xhr, status, error) {
                    alert("Error: " + error);
                }
            });
        });
    });
    </script>
</body>
</html>
