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

// Check if the product ID and quantity are provided
if (isset($_POST['productId']) && isset($_POST['quantity'])) {
    $productId = intval($_POST['productId']); // Sanitize the product ID
    $quantity = intval($_POST['quantity']); // Sanitize the quantity
    $cartId = $_SESSION['cartId']; // Get the cart ID from the session

    // Check if the product exists and has sufficient stock
    $stockQuery = "SELECT stock_quantity FROM product WHERE id = ?";
    $stockStmt = $mydatabase->prepare($stockQuery);
    $stockStmt->bind_param("i", $productId);
    $stockStmt->execute();
    $stockResult = $stockStmt->get_result()->fetch_assoc();

    if (!$stockResult) {
        echo json_encode(["success" => false, "message" => "Product not found."]);
        exit;
    }

    if ($stockResult['stock_quantity'] < $quantity) {
        echo json_encode(["success" => false, "message" => "Insufficient stock available."]);
        exit;
    }

    // Check if the product is already in the cart
    $checkCartQuery = "SELECT * FROM user_cart WHERE cartId = ? AND productId = ?";
    $stmt = $mydatabase->prepare($checkCartQuery);
    $stmt->bind_param("ii", $cartId, $productId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // If the product is already in the cart, increment the quantity
        $updateQuery = "UPDATE user_cart SET quantity = quantity + ? WHERE cartId = ? AND productId = ?";
        $updateStmt = $mydatabase->prepare($updateQuery);
        $updateStmt->bind_param("iii", $quantity, $cartId, $productId);
        $updateStmt->execute();
    } else {
        // If the product is not in the cart, insert it
        $insertQuery = "INSERT INTO user_cart (cartId, productId, quantity) VALUES (?, ?, ?)";
        $insertStmt = $mydatabase->prepare($insertQuery);
        $insertStmt->bind_param("iii", $cartId, $productId, $quantity);
        $insertStmt->execute();
    }

    echo json_encode(["success" => true, "message" => "Product added to cart successfully.", "remainingStock" => $stockResult['stock_quantity'] - $quantity]);
    exit;
} else {
    echo json_encode(["success" => false, "message" => "Invalid request."]);
    exit;
}
?>