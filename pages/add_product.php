<?php
$mydatabase = new mysqli("localhost", "root", "", "houseware_store");
if ($mydatabase->connect_error) {
    die("Connection failed:".$mydatabase->connect_error);
}

?>

<section class="form-container">
    <h3>Add New Product</h3>

    <form action="add_product.php" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="product_name">Product Name: <span style="color: red;">*</span></label>
            <input type="text" id="product_name" name="product_name" placeholder="Product Name" required>
        </div>

        <div class="form-group">
            <label >Product Category: <span style="color: red;">*</span></label>
            <div class="product-type">
                <?php
                $stmt = $mydatabase->query("SELECT * FROM category");
                while ($row = $stmt->fetch_assoc()) {
                    echo '<label>';
                    echo "<input type='radio' name='product_type' value='{$row['id']}' required> {$row['name']}";
                    echo '</label><br>';
                }
                ?>
                <label>
                    <input type="radio" name="product_type" value="new" id="new_category_radio" required> Create new category
                </label>
            </div>
        </div>

        <div id="new_category_input" style="display:none; margin-top:10px;">
            <input type="text" name="new_product_type" placeholder="Enter new category">
        </div>

        <div class="form-group">
            <label for="product_price">Product Price: <span style="color: red;">*</span></label>
            <input type="number" id="product_price" name="product_price" placeholder="Product Price" min="0" required>
        </div>
                
        <div class="form-group">
            <label for="product_quantity">Product Quantity: <span style="color: red;">*</span></label>
            <input type="number" id="product_quantity" name="product_quantity" placeholder="Product Quantity" min="0" required>
        </div>

        <div class="form-group">
            <label for="product_image">Product Image:</label>
            <input type="file" id="product_image" name="product_image" accept="image/*">
        </div>

        <div class="editor-group">
            <label>Product Description</label>
            <!-- Use Quill.js for rich text editor (must set id="editor")-->
            <div id="editor"></div>
        </div>

        <button type="submit">Add Product</button>
    </form>

</section>




