<?php
    $sel_product = $mydatabase->query("SELECT * FROM product WHERE id = '$_GET[productId]'")->fetch_assoc();
    $name = $sel_product['name'];
    $stock_quantity = $sel_product['stock_quantity'];
    $price = number_format($sel_product['price'], 0, '.', ',');
    $type_name = $mydatabase->query("SELECT name FROM category WHERE id = " .$sel_product['category_id'])->fetch_assoc()['name']; //get the type name from category table
    if (is_null($sel_product['image']) || $sel_product['image'] === '') {
        // Handle null/empty case, e.g., use a default image
        $image_path = "images/unavailable-img.jpg";
    } else
        $image_path = "images/$type_name/" .$sel_product['image'];
    $description = $sel_product['description'];
?>

<!-- Lightbox (Hidden by Default) -->
<div id="lightbox" class="lightbox" onclick="closeLightbox()">
    <img id="lightbox-img" class="lightbox-img">
</div>

<div class="view-container">
    <div class="main-part">
        <div class="image">
            <img class="clickable-img" src="<?=$image_path?>" alt="Product image"
            title="Click to zoom the image" onclick="openLightbox(this)">
        </div>

        <div class="info-site">
            <p class="name"><?=$name?></p>
            <div class="price">
                <p><?=$price?> &nbsp; VND</p>
            </div>
            <p id="stock-<?=$sel_product['id']?>" class="stock">Stock: <?=$stock_quantity?></p> <!-- Display stock quantity -->

            <div class="addtocart">
                <form class="change-num">

                    <input type="number" id="quantity-<?=$sel_product['id']?>" name="quantity" min="1" max="<?=$stock_quantity?>" value="1">

                </form>

                <button class="addtocart-btn" title="Add to Cart" onclick="addToCart(<?=$sel_product['id']?>)">
                    <img src="images/add-cart.png" alt="Add to Cart">
                </button>
            </div>
        </div>
    </div>

    <div class="description">
        <div class="description-title">
            <hr>
            <p>Product Description</p>
            <hr>
        </div>

        <div class="description-content">
            <p>
                <?=$description?>
            </p>
        </div>
    </div>

</div>