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

            $ipAddress = $_SERVER['REMOTE_ADDR'];
            $hashedIp = hash('sha256', $ipAddress);

            $banQuery = "SELECT reason FROM bans WHERE ip_address = ?";
            $stmt = $conn->prepare($banQuery);
            $stmt->bind_param("s", $hashedIp);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $stmt->bind_result($reason);
                $stmt->fetch();
                echo "Registration Failed: Your IP is banned. Reason: " . htmlspecialchars($reason);
                $stmt->close();
                $conn->close();
                exit();
            }

            $query = "SELECT id FROM user WHERE username = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows === 0) {

                $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
                $query = "INSERT INTO user (username, password) VALUES (?, ?)";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("ss", $username, $hashedPassword);
                $stmt->execute();

                $query = "INSERT INTO ips (username, ip_address) VALUES (?, ?)";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("ss", $username, $hashedIp);
                $stmt->execute();

                $stmt->close();
                $conn->close();

                header("Location: ../user/login.php");
                exit();
            } else {
                echo "Username already exists";
            }

            $stmt->close();
            $conn->close();
        } else {
            echo "Username or password not provided.";
        }
    }
}
?>