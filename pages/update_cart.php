<?php
session_start();
$mydatabase = new mysqli("localhost", "root", "", "houseware_store");

if ($mydatabase->connect_error) {
    die("Connection failed: " . $mydatabase->connect_error);
}

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    echo json_encode(["success" => false, "message" => "You must be logged in to update the cart."]);
    exit;
}

// Handle quantity update
if (isset($_POST['action']) && $_POST['action'] === 'update_quantity') {
    $productId = intval($_POST['productId']);
    $quantity = intval($_POST['quantity']);

    if ($quantity < 1) {
        echo json_encode(["success" => false, "message" => "Quantity must be at least 1."]);
        exit;
    }

    // Update the quantity in the database
    $query = "UPDATE user_cart SET quantity = ? WHERE cartId = (SELECT id FROM cart WHERE username = ?) AND productId = ?";
    $stmt = $mydatabase->prepare($query);
    $stmt->bind_param("isi", $quantity, $_SESSION['username'], $productId);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        // Get the updated individual price and total cart price
        $priceQuery = "SELECT price FROM product WHERE id = ?";
        $priceStmt = $mydatabase->prepare($priceQuery);
        $priceStmt->bind_param("i", $productId);
        $priceStmt->execute();
        $priceResult = $priceStmt->get_result()->fetch_assoc();
        $price = $priceResult['price'];
        $individualTotal = number_format($price * $quantity, 0, '.', ',');

        $totalQuery = "SELECT SUM(p.price * uc.quantity) AS total_cost
                       FROM user_cart AS uc
                       JOIN product AS p ON uc.productId = p.id
                       WHERE uc.cartId = (SELECT id FROM cart WHERE username = ?)";
        $totalStmt = $mydatabase->prepare($totalQuery);
        $totalStmt->bind_param("s", $_SESSION['username']);
        $totalStmt->execute();
        $totalResult = $totalStmt->get_result()->fetch_assoc();
        $totalCost = number_format($totalResult['total_cost'], 0, '.', ',');

        echo json_encode([
            "success" => true,
            "individualTotal" => $individualTotal,
            "totalCost" => $totalCost
        ]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to update quantity."]);
    }
    exit;
}

// Handle item removal
if (isset($_POST['action']) && $_POST['action'] === 'remove_item') {
    $productId = intval($_POST['productId']);

    $query = "DELETE FROM user_cart WHERE cartId = (SELECT id FROM cart WHERE username = ?) AND productId = ?";
    $stmt = $mydatabase->prepare($query);
    $stmt->bind_param("si", $_SESSION['username'], $productId);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        // Get the updated total cart price
        $totalQuery = "SELECT SUM(p.price * uc.quantity) AS total_cost
                       FROM user_cart AS uc
                       JOIN product AS p ON uc.productId = p.id
                       WHERE uc.cartId = (SELECT id FROM cart WHERE username = ?)";
        $totalStmt = $mydatabase->prepare($totalQuery);
        $totalStmt->bind_param("s", $_SESSION['username']);
        $totalStmt->execute();
        $totalResult = $totalStmt->get_result()->fetch_assoc();
        $totalCost = number_format($totalResult['total_cost'], 0, '.', ',');

        echo json_encode([
            "success" => true,
            "totalCost" => $totalCost
        ]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to remove item."]);
    }
    exit;
}

echo json_encode(["success" => false, "message" => "Invalid action."]);
?>