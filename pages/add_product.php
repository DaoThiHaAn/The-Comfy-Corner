<?php
$name = $img_file_name = '';
$category_id = $price = $stock_quantity = 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the new category is selected
    if (isset($_POST['new_product_type']) && $_POST['product_type'] == 'new_category') {
        $new_category_name = test_input($_POST['new_product_type']);

        // Check if the new category already exists
        $stmt = $mydatabase->prepare("SELECT id FROM category WHERE LOWER(name) = LOWER(?)");
        $stmt->bind_param("s", $new_category_name);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "<script>
            window.addEventListener('DOMContentLoaded', function() {
                openDialog(['Category already exists!', 'Please choose a different name.']);
            });
            </script>";
        } else {
            // Insert the new category into the database
            $stmt = $mydatabase->prepare("INSERT INTO category (name) VALUES (?)");
            $stmt->bind_param("s", $new_category_name);
            if ($stmt->execute()) {
                $category_id = $mydatabase->insert_id;
                echo "<script>console.log('New category ID: " . $category_id . "');</script>"; // Debugging line
            } else {
                echo "<script>alert('Failed to insert new category. Please try again.');</script>";
            }
        }
    } else {
        // Use the selected category ID
        $category_id = intval(test_input($_POST['product_type']));
            // Insert the product into the database
    $name = test_input($_POST['product_name']);
    $price = test_input($_POST['product_price']);
    $stock_quantity = test_input($_POST['product_quantity']);
    $img_file_name = isset($_FILES['product_image']) ? $_FILES['product_image']['name'] : '';
    $description = $_POST['description'];

    $stmt = $mydatabase->prepare("INSERT INTO product (name, price, stock_quantity, image, description, category_id) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sdissi", $name, $price, $stock_quantity, $img_file_name, $description, $category_id);
    
    if ($stmt->execute()) {
        echo "<script>
        window.addEventListener('DOMContentLoaded', function() {
            openDialog(['Product inserted successfully!'], 'Success!');
        });
        </script>";
    } else {
        echo "<script>
        alert('Error: ".$mydatabase->error."\nPlease try again! 🥲');
            </script>";
    }

    }

}
?>

<section class="form-container">
    <h2>Add New Product</h2>

    <form action="add_product" class="add-form" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label class="label" for="product_name">Product Name: <span style="color: red;">*</span></label>
            <input type="text" id="product_name" name="product_name" placeholder="Product Name"
                value="<?php echo htmlspecialchars($name); ?>" maxlength="255" required>
        </div>

        <div class="form-group">
            <label class="label">Product Category: <span style="color: red;">*</span></label>
            <div class="product-type">
                <?php
                $stmt = $mydatabase->query("SELECT * FROM category");
                while ($row = $stmt->fetch_assoc()) {
                    echo '<label>';
                    echo "<input type='radio' name='product_type' value='{$row['id']}' required> " . ucfirst($row['name']);
                    echo '</label><br>';
                }
                ?>
                <label>
                    <input type="radio" name="product_type" id="new_category_radio" value="new_category"> Create new category
                </label>
            </div>

            <div class="form-group" id="new_category_input">
                <p>Note: The name of category is case-insensitve and must be unique</p>
                <input id="new-input" type="text" name="new_product_type" placeholder="Enter new category" maxlength="255">
            </div>

        </div>


        <div class="form-group">
            <label class="label" for="product_price">Product Price (VND): <span style="color: red;">*</span></label>
            <input type="number" id="product_price" name="product_price" placeholder="Product Price" min="0" 
                value="<?php echo htmlspecialchars($price); ?>" required>
        </div>
                
        <div class="form-group">
            <label class="label" for="product_quantity">Product Quantity: <span style="color: red;">*</span></label>
            <input type="number" id="product_quantity" name="product_quantity" placeholder="Product Quantity" min="0" 
                value="<?php echo htmlspecialchars($stock_quantity); ?>" required>
        </div>

        <div class="form-group">
            <label class="label" for="product_image">Product Image:</label>
            <input type="file" id="product_image" name="product_image" accept="image/*">
            <img id="file-preview" style="max-width:100px; display:none;" alt="Image preview">
        </div>

        <div class="editor-group">
            <label class="label">Product Description</label>
            <!-- Use Quill.js for rich text editor (must set id="editor")-->
            <div id="editor"></div>
        </div>

         <!-- Hidden field to store the editor content -->
        <input type="hidden" name="description" id="description">
        <button type="submit">Add Product</button>
    </form>

</section>




