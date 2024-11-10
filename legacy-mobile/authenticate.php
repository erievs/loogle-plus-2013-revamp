<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (!empty($username) && !empty($password)) {

        include("../important/db.php");

        $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $query = "SELECT password FROM user WHERE username = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->bind_result($storedPassword);
        $stmt->fetch();

        if (password_verify($password, $storedPassword)) {
            $_SESSION['username'] = $username;
            header("Location: index.php");
            exit();
        } else {
            echo "Login Failed";
        }

        $stmt->close();
        $conn->close();
    }
}

header("Location: user/login.php");
?>