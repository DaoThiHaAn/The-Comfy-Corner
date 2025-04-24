<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$mydatabase = new mysqli("localhost", "root", "", "houseware_store");
if ($mydatabase->connect_error) {
    die("Connection failed:".$mydatabase->connect_error);
}
// Clear cart of users
$products = $mydatabase->query("SELECT * FROM user_cart WHERE cartId = {$_SESSION['cartId']};");
// change the product stock quantity
while ($row = $products->fetch_assoc()) {
    $productId = $row['productId'];
    $quantity = $row['quantity'];
    $mydatabase->query("UPDATE product SET stock_quantity = stock_quantity - $quantity WHERE id = $productId;");
}
$query = "DELETE FROM user_cart WHERE cartId = {$_SESSION['cartId']};";
if ($mydatabase->query($query)) {
    echo "<script>
alert('Order successfully');
window.location.href='products';
</script>";
} else {
    echo "<script>
alert('Order failed! Please try again.');
window.location.href='cart_view';
</script>";
}
?>