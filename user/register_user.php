<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (!empty($username) && !empty($password)) {

        include("../important/db.php");

        $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $existingUserQuery = "SELECT username FROM user WHERE username = '$username'";
        $result = $conn->query($existingUserQuery);

        if ($result->num_rows > 0) {
            $error = "Username already exists. Please choose a different username.";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $insertQuery = "INSERT INTO user (username, password) VALUES ('$username', '$hashedPassword')";
            
            if ($conn->query($insertQuery) === TRUE) {
                $conn->close();
                header("Location: login.php");
                exit;
            } else {
                echo "Error: " . $insertQuery . "<br>" . $conn->error;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register User</title>
    <style>
     body {
            font-family: 'Roboto', sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-container {
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 30px;
            width: 300px;
        }

        .login-title {
            font-size: 20px;
            margin: 20px 0;
            text-align: center;
        }

        .login-form label {
            font-size: 14px;
            display: block;
            margin-bottom: 5px;
        }

        .login-form input[type="text"],
        .login-form input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }

        .login-form button {
            background-color: #4285f4;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 10px 20px;
            font-size: 14px;
            cursor: pointer;
            width: 100%;
        }

        .warning {
            font-size: 12px;
            color: #db4437;
            margin-top: 15px;
            text-align: center;
        }

        /* Additional styles for registration form */
        /* Customize these styles as needed for your registration form */
        .registration-title {
            font-size: 20px;
            margin: 20px 0;
            text-align: center;
        }

        .registration-form label {
            font-size: 14px;
            display: block;
            margin-bottom: 5px;
        }

        .registration-form input[type="text"],
        .registration-form input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }

        .registration-form button {
            background-color: #4285f4;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 10px 20px;
            font-size: 14px;
            cursor: pointer;
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2 class="registration-title">Register</h2>
        <?php if (isset($error)) { ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php } ?>
        <form class="registration-form" method="post" action="register_user.php">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required><br><br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br><br>
            <button type="submit">Register</button>
        </form>
        <br>
        <a href="login.php">Already Have A Loogle Account?</a>
    </div>
   
</body>
</html>

