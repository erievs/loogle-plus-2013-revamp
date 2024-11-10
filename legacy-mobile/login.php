<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css">
    <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
</head>
<body>
    <div data-role="page" id="login-page">
        <div data-role="header">
            <h1>Sign in</h1>
        </div>

        <div data-role="content">
            <form id="login-form" method="post" action="authenticate.php">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
                <button type="submit" data-theme="b">Sign In</button>
            </form>
            <p class="warning">Not your Loogle Account? Find out why</p>
        </div>
    </div>

    <script>
        $(document).on("pagecreate", "#login-page", function () {

            $("#login-form").on("submit", function (e) {
                e.preventDefault();

                var username = $("#username").val();
                var password = $("#password").val();

                $.ajax({
                    url: "authenticate.php",
                    method: "POST",
                    data: {
                        username: username,
                        password: password
                    },
                    success: function (response) {
                        if (response === "success") {

                            window.location.href = "main.html"; 
                        } else {

                            alert("Authentication failed. Please check your credentials.");
                        }
                    },
                    error: function () {

                        alert("Error connecting to the server. Please try again later.");
                    }
                });
            });
        });
    </script>
</body>
</html>