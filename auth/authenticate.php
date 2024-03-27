<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['username']) && isset($_POST['password'])) {
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
            $stmt->store_result();
            
            if ($stmt->num_rows === 1) {
                $stmt->bind_result($storedPassword);
                $stmt->fetch();
                if (password_verify($password, $storedPassword)) {
                    $_SESSION['username'] = $username;
                    $stmt->close();
                    $conn->close();
                    header("Location: ../index.php"); 
                    exit();
                } else {
                    echo "Login Failed";
                }
            } else {
                echo "User not found";
            }

            $stmt->close();
            $conn->close();
        }
    } else {
        echo "Username or password not provided.";
    }
}
?>
