<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$mydatabase = new mysqli("localhost", "root", "", "houseware_store");
if ($mydatabase->connect_error) {
    die("Connection failed:".$mydatabase->connect_error);
}

// create purchase
$query = "INSERT INTO purchase (username, total_price) VALUES ('{$_SESSION['username']}', {$_SESSION['totalCost']});";
if ($mydatabase->query($query)) {
    $purchaseId = $mydatabase->insert_id; // Get the last inserted purchase ID

    // create order history
    $query = "SELECT productId, quantity FROM user_cart WHERE cartId = {$_SESSION['cartId']};";
    $result = $mydatabase->query($query);
    while ($row = $result->fetch_assoc()) {
        $productId = $row['productId'];
        $quantity = $row['quantity'];

        // Insert into purchase_detail table
        $query = "INSERT INTO purchase_detail (purchaseId, productId, quantity) VALUES ($purchaseId, $productId, $quantity);";
        if (!$mydatabase->query($query)) {
            echo "<script>
            alert('Order failed! Please try again.');
            window.location.href='cart_view';
            </script>";
            exit;
        }
        // change the product stock quantity
        $mydatabase->query("UPDATE product SET stock_quantity = stock_quantity - $quantity WHERE id = $productId;");

    }

    // Clear cart of users
    $query = "DELETE FROM user_cart WHERE cartId = {$_SESSION['cartId']};";
    if ($mydatabase->query($query)) {
        echo "<script>
    alert('Order successfully');
    window.location.href='order_view/$purchaseId';
    </script>";
    } else {
        echo "<script>
    alert('Order failed! Please try again.');
    window.location.href='cart_view';
    </script>";
    }
}
else {
    echo "<script>
alert('Order failed! Please try again.');
window.location.href='cart_view';
</script>";
}
?>