<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$mydatabase = new mysqli("localhost", "root", "", "houseware_store");
$query = "SELECT * 
  FROM cart AS c
  JOIN user_cart AS uc ON c.id = uc.cartId
  WHERE c.username = '{$_SESSION['username']}'";
$result = $mydatabase->query($query);
?>

<section class="container">
    <h1>Your Cart</h1>

    <?php if ($result->num_rows == 0) { 
     echo "
     <h3>NO ITEM IN YOUR CART!</h3>
     <p>Choose your favorite items and add them to the cart.</p>";
    } else {
      $total_price = 0;
      while ($row = $result->fetch_assoc()) {
        // Get product details
        $query = "SELECT name, price, image, category_id FROM product WHERE id = " .$row['productId'];
        $result2 = $mydatabase->query($query)->fetch_assoc();
        // Get image
        $type_name = $mydatabase->query("SELECT name FROM category WHERE id = " .$result2['category_id'])->fetch_assoc()['name']; //get the type name from category table
        $image_path = "images/$type_name/" .$result2['image'];

        $name = $result2['name'];
        $price = number_format($result2['price'], 0, '.', ',');
        $number = $row['quantity']; 
        $total_price += $result2['price'] * $number;                
    ?>

    <!-- Cart Item -->
    <div class="cart-item" data-product-id="<?= $row['productId']; ?>">
      <div class="item-number">
        <p><?= $row['productId']; ?></p>
      </div>
      <div class="main-info">
        <img src="<?= $image_path; ?>" alt="<?= $name; ?>" />
        <div class="item-details">
          <h3><?= $name; ?></h3>
          <p data-price="<?= $result2['price']; ?>">Price: <?= $price; ?></p>
        </div>
      </div>
      <div class="action-zone">
        <div class="item-actions">
          <input type="number" value="<?= $number; ?>" min="1" onchange="updateQuantity(<?= $row['productId']; ?>, this)" />
          <button class="remove-btn" onclick="removeItem(<?= $row['productId']; ?>, this)">Remove</button>
        </div>
        <div>
          <p>Subtotal:&nbsp;
          <span class="item-price"><?= number_format($result2['price'] * $number, 0, '.', ','); ?> VND</span>
          </p>
        </div>
      </div>

    </div>
    <?php } ?>

    <!-- Cart Summary -->
    <div class="cart-summary">
      <h2>
        Total: 
        <span> <?= number_format($total_price, 0, '.', ','); ?> VND</span>
      </h2>
      <button class="checkout-btn" onclick="window.location.href='checkout'">Proceed to Checkout</button>
    </div>
</section>
<?php } ?>