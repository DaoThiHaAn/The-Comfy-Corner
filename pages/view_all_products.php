
<section class="container">
    <h2>Product List</h2>

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