<?php
$name = $img_file_name = '';
$category_id = $price = $stock_quantity = 0;
$description = '';

if (isset($_GET['id'])) {
    $product_id = intval($_GET['id']); // Sanitize the product ID

    // Fetch product data from the database
    $stmt = $mydatabase->prepare("SELECT * FROM product WHERE id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $product = $stmt->get_result()->fetch_assoc();

    if ($product) {
        $name = $product['name'];
        $price = $product['price'];
        $stock_quantity = $product['stock_quantity'];
        $img_file_name = $product['image'];
        $description = $product['description'];
        $category_id = $product['category_id'];
    } else {
        echo "<script>alert('Product not found!'); window.location.href='view_all_products.php';</script>";
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = test_input($_POST['product_name']);
    $price = test_input($_POST['product_price']);
    $stock_quantity = test_input($_POST['product_quantity']);
    $description = $_POST['description'];
    $category_id = intval(test_input($_POST['product_type']));
    $img_file_name = isset($_FILES['product_image']) && $_FILES['product_image']['name'] ? $_FILES['product_image']['name'] : $img_file_name;

    // Update the product in the database
    $stmt = $mydatabase->prepare("UPDATE product SET name = ?, price = ?, stock_quantity = ?, image = ?, description = ?, category_id = ? WHERE id = ?");
    $stmt->bind_param("sdissii", $name, $price, $stock_quantity, $img_file_name, $description, $category_id, $product_id);

    if ($stmt->execute()) {
        echo "<script>alert('Product updated successfully!'); window.location.href='view_all_products.php';</script>";
    } else {
        echo "<script>alert('Error updating product: {$mydatabase->error}');</script>";
    }
}
?>

<section class="form-container">
    <h2>Edit Product</h2>

    <form action="<?=htmlspecialchars($_SERVER['PHP_SELF']) . '?id=' . $product_id?>" class="edit-form" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label class="label" for="product_name">Product Name: <span style="color: red;">*</span></label>
            <input type="text" id="product_name" name="product_name" placeholder="Product Name"
                value="<?=htmlspecialchars($name)?>" maxlength="255" required>
        </div>

        <div class="form-group">
            <label class="label">Product Category: <span style="color: red;">*</span></label>
            <div class="product-type">
                <?php
                $stmt = $mydatabase->query("SELECT * FROM category");
                while ($row = $stmt->fetch_assoc()) {
                    $checked = $row['id'] == $category_id ? 'checked' : '';
                    echo '<label>';
                    echo "<input type='radio' name='product_type' value='{$row['id']}' $checked required> " . ucfirst($row['name']);
                    echo '</label><br>';
                }
                ?>
            </div>
        </div>

        <div class="form-group">
            <label class="label" for="product_price">Product Price (VND): <span style="color: red;">*</span></label>
            <input type="number" id="product_price" name="product_price" placeholder="Product Price" min="0" 
                value="<?=htmlspecialchars($price)?>" required>
        </div>
                
        <div class="form-group">
            <label class="label" for="product_quantity">Product Quantity: <span style="color: red;">*</span></label>
            <input type="number" id="product_quantity" name="product_quantity" placeholder="Product Quantity" min="0" 
                value="<?=htmlspecialchars($stock_quantity)?>" required>
        </div>

        <div class="form-group">
            <label class="label" for="product_image">Product Image:</label>
            <input type="file" id="product_image" name="product_image" accept="image/*">
            <?php if (!empty($img_file_name)): ?>
                <img id="file-preview" src="images/<?=$img_file_name?>" style="max-width:100px;" alt="Product Image">
            <?php endif; ?>
        </div>

        <div class="editor-group">
            <label class="label">Product Description</label>
            <!-- Use Quill.js for rich text editor (must set id="editor")-->
            <div id="editor"><?=$description?></div>
        </div>

        <!-- Hidden field to store the editor content -->
        <input type="hidden" name="description" id="description">
        <button type="submit">Save Changes</button>
    </form>
</section>




