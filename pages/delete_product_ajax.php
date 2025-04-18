<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$mydatabase = new mysqli("localhost", "root", "", "houseware_store");

if ($mydatabase->connect_error) {
    die(json_encode(["success" => false, "message" => "Database connection failed."]));
}

// Check if the product ID is provided
if (isset($_POST['product_id'])) {
    $id = intval($_POST['product_id']); // Sanitize the product ID

    // Prepare and execute the delete query
    $stmt = $mydatabase->prepare("DELETE FROM product WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Product deleted successfully!"]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to delete product."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid request."]);
}
?>