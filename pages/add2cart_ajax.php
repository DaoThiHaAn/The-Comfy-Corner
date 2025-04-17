<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
    echo json_encode(["success" => false, "message" => "You must be logged in to add items to the cart."]);
    exit;
}

// Check if the product ID is provided
if (isset($_POST['productId'])) {
    $productId = intval($_POST['productId']); // Sanitize the product ID

    // Initialize the cart if it doesn't exist
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Check if the product is already in the cart
    if (isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId]['quantity'] += 1; // Increment the quantity
    } else {
        // Add the product to the cart with a quantity of 1
        $_SESSION['cart'][$productId] = [
            'productId' => $productId,
            'quantity' => 1
        ];
    }

    echo json_encode(["success" => true, "message" => "Product added to cart successfully."]);
    exit;
} else {
    echo json_encode(["success" => false, "message" => "Product ID is missing."]);
    exit;
}

$mydatabase = new mysqli("localhost", "root", "", "houseware_store");
if ($mydatabase->connect_error) {
    die("Connection failed:".$mydatabase->connect_error);
}

?>