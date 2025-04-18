<?php
// --- Pagination Setup ---
$limit = 20; // Products per page
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($page - 1) * $limit;

// --- Fetch total count ---
$result = $mydatabase->query("SELECT COUNT(*) as count FROM product");
$total_rows = $result->fetch_assoc()['count'];
$total_pages = ceil($total_rows / $limit);

// --- Fetch current page of products ---
$stmt = $mydatabase->prepare("SELECT p.*, c.name as category_name FROM product p 
                              LEFT JOIN category c ON p.category_id = c.id 
                              ORDER BY p.id DESC LIMIT ? OFFSET ?");
$stmt->bind_param("ii", $limit, $offset);
$stmt->execute();
$products = $stmt->get_result();
?>

<section class="container">
    <h2>Product Management</h2>

    <!-- Search and Filter -->
    <div class="search-filter">
        <input type="text" id="search" placeholder= "🔎 Search by product name..." oninput="fetchProducts()">
        <select id="category" onchange="fetchProducts()">
            <option value="all">All Categories</option>
            <?php
            $categories = $mydatabase->query("SELECT * FROM category");
            while ($cat = $categories->fetch_assoc()) {
                echo "<option value='{$cat['id']}'>" . htmlspecialchars($cat['name']) . "</option>";
            }
            ?>
        </select>
    </div>

    <!-- Products Table -->
    <table>
        <thead>
            <tr>
                <th></th>
                <th>Name</th>
                <th>Category</th>
                <th>Price (VND)</th>
                <th>Stock</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="products-table">
            <!-- Products will be loaded here via AJAX -->
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="pagination" id="pagination">
        <!-- Pagination will be loaded here via AJAX -->
    </div>
</section>