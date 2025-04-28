<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$mydatabase = new mysqli("localhost", "root", "", "houseware_store");
$row = $mydatabase->query("SELECT time_create, total_price FROM purchase WHERE id = {$_GET['purchaseId']}")->fetch_assoc();
$time_create = $row['time_create'];
$total_price = $row['total_price'];

$query = "SELECT * 
  FROM purchase_detail AS pd
  JOIN product AS p ON pd.productId = p.id
  WHERE pd.purchaseId = {$_GET['purchaseId']}";
$result = $mydatabase->query($query);
?>

<section class="container">
    <h1>Order Detail</h1>

    <div class="purchase-info">
        <p>Order ID: &nbsp; <?= $_GET['purchaseId'] ?></p>
        <p>Time ordered:&nbsp; <?=$time_create?></p>
        <?php if ($_SESSION['role'] == 'admin')
            echo "<p>Customer: &nbsp; {$mydatabase->query("SELECT username FROM purchase WHERE id = {$_GET['purchaseId']}")->fetch_assoc()['username']}</p>";
        ?>
    </div>

    <?php
    $i = 1;
      while ($row = $result->fetch_assoc()) {
        // Get product details
        $query = "SELECT name, price, image, category_id FROM product WHERE id = " .$row['productId'];
        $result2 = $mydatabase->query($query)->fetch_assoc();
        // Get image
        $type_name = $mydatabase->query("SELECT name FROM category WHERE id = " .$result2['category_id'])->fetch_assoc()['name']; //get the type name from category table
        $image_path = $_SESSION['base_url']."images/$type_name/" .$result2['image'];

        $name = $result2['name'];
        $price = number_format($result2['price'], 0, '.', ',');
        $number = $row['quantity']; 
    ?>

    <!-- Cart Item -->
    <div class="cart-item" data-product-id="<?= $row['productId']; ?>">
      <div class="item-number">
        <p><?= $i++; ?></p>
      </div>
      <div class="main-info">
        <img src="<?= $image_path; ?>" alt="<?= $name; ?>" />
        <div class="item-details">
          <h3><?= $name; ?></h3>
          <p data-price="<?= $result2['price']; ?>">Price: <?= $price; ?></p>
        </div>
      </div>
      <div class="action-zone">
        <p>Quantity: &nbsp; <?=$number?> </p>
        <div>
          <p>Subtotal:&nbsp;
          <span class="item-price"><?= number_format($result2['price'] * $number, 0, '.', ','); ?> VND</span>
          </p>
        </div>
      </div>

    </div>
    <?php } ?>

    <div class="cart-summary">
      <h2>
        Total: 
        <span> <?= number_format($total_price, 0, '.', ','); ?> VND</span>
      </h2>
    </div>
</section>
