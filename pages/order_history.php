<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$mydatabase = new mysqli("localhost", "root", "", "houseware_store");
if ($mydatabase->connect_error) {
    die("Connection failed: " . $mydatabase->connect_error);
}


// Fetch all orders for the logged-in user
$query = "SELECT p.id AS purchaseId, p.total_price, p.time_create, 
                 GROUP_CONCAT(pd.productId) AS productIds, 
                 GROUP_CONCAT(pd.quantity) AS quantities
          FROM purchase p
          JOIN purchase_detail pd ON p.id = pd.purchaseId
          WHERE p.username = ?
          GROUP BY p.id
          ORDER BY p.time_create DESC";

$stmt = $mydatabase->prepare($query);
$stmt->bind_param("s", $_SESSION['username']);
$stmt->execute();
$result = $stmt->get_result();

?>

<h1>Your Order History</h1>
<section class="container">
    <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()):                 
            // Get total product quantity
            $query = "SELECT quantity FROM purchase_detail WHERE purchaseId = {$row['purchaseId']}";
            $result2 = $mydatabase->query($query);
            $total_quantity = 0;
            while ($row2 = $result2->fetch_assoc()) {
                $total_quantity += $row2['quantity'];
            }
        ?>
        <a class="order-card" href="<?= $_SESSION['base_url'] ?>order_view/<?= $row['purchaseId']; ?>" data-purchase-id="<?= $row['purchaseId']; ?>">
                <h3>Order ID: <?= $row['purchaseId']; ?></h3>
                <p><strong>Time Ordered:</strong> <?= $row['time_create']; ?></p>
                <p><strong>Total Price:</strong> <?= number_format($row['total_price'], 0, '.', ','); ?> VND</p>
                <p><strong>Total Items:</strong> <?= $total_quantity; ?></p>
        </a>
        <?php endwhile; ?>
    <?php else: ?>
        <p>You have no order history.</p>
    <?php endif; ?>
</section>