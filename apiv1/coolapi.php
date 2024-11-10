<?php
include("../important/db.php");
$content = $_POST['content'] ?? '';

if (!empty($content)) {
    // Check if the database connection is established
    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

    if ($conn) {
        // Define the sender
        $sender = "Big Brother";

        $sql = "SELECT username FROM user";
        $result = $conn->query($sql);

        if ($result) {
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $recipient = $row['username'];

                    // Modify the SQL statement to insert content into the 'content' column
                    $stmt = $conn->prepare("INSERT INTO notifications (sender, recipient, content) VALUES (?, ?, ?)");
                    $stmt->bind_param("sss", $sender, $recipient, $content);
                    $stmt->execute();
                    $stmt->close();
                }
                echo "Notifications sent to all users successfully.";
            } else {
                echo "No users found.";
            }
        } else {
            echo "Error executing query: " . $conn->error;
        }
    } else {
        echo "Database connection is not established.";
    }
} else {
    echo "Content is required.";
}
?>
