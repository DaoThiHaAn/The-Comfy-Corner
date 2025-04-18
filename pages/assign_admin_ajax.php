<?php
session_start();
$mydatabase = new mysqli("localhost", "root", "", "houseware_store");

if ($mydatabase->connect_error) {
    die(json_encode(["success" => false, "message" => "Database connection failed."]));
}

// Check if the username is provided
if (isset($_POST['username'])) {
    $username = $_POST['username']; // Sanitize the username

    // Update the user's role to 'admin'
    $stmt = $mydatabase->prepare("UPDATE account SET role = 'admin' WHERE username = ?");
    $stmt->bind_param("s", $username);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "User has been made an admin."]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to assign admin role."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid request."]);
}
?>