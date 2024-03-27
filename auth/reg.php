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
                header("Location: ../user/login.php");
                exit;
            } else {
                echo "Error: " . $insertQuery . "<br>" . $conn->error;
            }
        }
    }
}
?>
