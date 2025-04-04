<?php
require_once 'db_connection.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $mydatabase->prepare("DELETE FROM product WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: admin_products.php?msg=deleted");
    } else {
        echo "Failed to delete product.";
    }
}
