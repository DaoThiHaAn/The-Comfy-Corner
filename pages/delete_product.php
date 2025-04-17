<?php
require_once 'db_connection.php';

if (isset($_GET['product_id'])) {
    $id = intval($_GET['product_id']);
    $stmt = $mydatabase->prepare("DELETE FROM product WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "<script>
                alert('Product deleted successfully!');
                window.location.href = 'index.php?page=products';
            </script>";
    } else {
        echo "<script>alert('Failed to delete product!');</script>";
    }
}
