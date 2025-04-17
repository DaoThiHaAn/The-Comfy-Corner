<?php
session_start();
$mydatabase = new mysqli("localhost", "root", "", "houseware_store");

if ($mydatabase->connect_error) {
    die("Connection failed: " . $mydatabase->connect_error);
}

// Check if the user is logged in
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'user') {
    echo json_encode(["success" => false, "message" => "You must be logged in to add items to the cart."]);
    exit;
}

// Check if the product ID is provided
if (isset($_POST['productId'])) {
    $productId = intval($_POST['productId']); // Sanitize the product ID
    $cartId = $_SESSION['cartId']; // Get the cart ID from the session

    // Check if the product is already in the cart
    $checkCartQuery = "SELECT * FROM user_cart WHERE cartId = ? AND productId = ?";
    $stmt = $mydatabase->prepare($checkCartQuery);
    $stmt->bind_param("ii", $cartId, $productId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // If the product is already in the cart, increment the quantity
        $updateQuery = "UPDATE user_cart SET quantity = quantity + 1 WHERE cartId = ? AND productId = ?";
        $updateStmt = $mydatabase->prepare($updateQuery);
        $updateStmt->bind_param("ii", $cartId, $productId);
        $updateStmt->execute();
    } else {
        // If the product is not in the cart, insert it
        $insertQuery = "INSERT INTO user_cart (cartId, productId, quantity) VALUES (?, ?, 1)";
        $insertStmt = $mydatabase->prepare($insertQuery);
        $insertStmt->bind_param("ii", $cartId, $productId);
        $insertStmt->execute();
    }

    echo json_encode(["success" => true, "message" => "Product added to cart successfully."]);
    exit;
} else {
    echo json_encode(["success" => false, "message" => "Product ID is missing."]);
    exit;
}
?>