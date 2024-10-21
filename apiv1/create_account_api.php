<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $input = file_get_contents("php://input");
    $data = json_decode($input, true);

    if (isset($data['username']) && isset($data['password'])) {
        $username = $data['username'];
        $password = $data['password'];

        if (!empty($username) && !empty($password)) {
            include("../important/db.php");

            $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
            if ($conn->connect_error) {
                die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
            }

            $ipAddress = $_SERVER['REMOTE_ADDR'];
            $hashedIp = md5($ipAddress);

            $query = "SELECT reason FROM bans WHERE username = ? LIMIT 1";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $stmt->bind_result(var: $banReason);
                $stmt->fetch();
                echo json_encode(value: ["error" => "This username is banned: " . htmlspecialchars($banReason)]);
                $stmt->close();
                $conn->close();
                exit();
            }

            $banQuery = "SELECT reason FROM bans WHERE ip_address = ?";
            $stmt = $conn->prepare($banQuery);
            $stmt->bind_param("s", $hashedIp);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $stmt->bind_result($reason);
                $stmt->fetch();
                echo json_encode(["error" => "Registration Failed: Your IP is banned. Reason: " . htmlspecialchars($reason)]);
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

                echo json_encode(["success" => "Account created successfully."]);
                exit();
            } else {
                echo json_encode(["error" => "Username already exists."]);
            }

            $stmt->close();
            $conn->close();
        } else {
            echo json_encode(["error" => "Username or password not provided."]);
        }
    } else {
        echo json_encode(["error" => "Invalid input."]);
    }
} else {
    echo json_encode(["error" => "Invalid request method."]);
}
?>