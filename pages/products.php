<section class="container">
    <div class="filter-sort">
        <!-- Responsive design: hide filter and sort on small screens -->
        <button class="filter-icon" id="filter-icon">
            <img src="images/funnel.png" alt="Filter icon">
        </button>

        <h3> <img src="images/funnel.png" alt="Filter icon">
            <span>Filter and Sort</span>
        </h3><hr>
        <form action="index.php" method="GET">
            <input type="hidden" name="page" value="products">
                <p> Categories</p>
                <div class="filter-category">
                    <?php
                        $selected_categories = isset($_GET['category']) ? $_GET['category'] : []; // Get selected categories from the URL
                        $categories = $mydatabase->query("SELECT * FROM category");
                        while ($category = $categories->fetch_assoc()) {
                            $category_name = $category['name'];
                            $category_id = $category['id'];
                            $is_checked = in_array($category_id, $selected_categories) ? "checked" : ""; // Check if the category is selected
                    ?>
                    <div>  <!-- Create a checkbox for each category and an array for category selection -->
                        <input type="checkbox" name="category[]" value="<?=$category_id?>" <?=$is_checked?>>
                        <label><?php echo ucfirst($category_name); ?></label>
                    </div>
                    <?php } ?>
                </div>

            <div class="sort">
                <p>Sort</p>
                <div class="sort-option">
                    <select name="sort" id="sort" onchange="loadProducts()">
                        <?php
                        $current_sort = isset($_GET['sort']) ? $_GET['sort'] : 'none'; // Get the current sort value from the URL
                        ?>
                        <option value="none" <?= $current_sort === 'none' ? 'selected' : '' ?>>None</option>
                        <option value="name-asc" <?= $current_sort === 'name-asc' ? 'selected' : '' ?>>Name: A to Z</option>
                        <option value="name-desc" <?= $current_sort === 'name-desc' ? 'selected' : '' ?>>Name: Z to A</option>
                        <option value="price-asc" <?= $current_sort === 'price-asc' ? 'selected' : '' ?>>Price: Low to High</option>
                        <option value="price-desc" <?= $current_sort === 'price-desc' ? 'selected' : '' ?>>Price: High to Low</option>
                    </select>
                </div>
            </div><br><br>
        </>

        <button class="showall-btn">
            Show All
        </button>

        <div>
            <p>Results</p><hr>  
            <!--show the number of results from AJAX-->
            <p class="result"></p>
            
        </div>
    </div>

    <section class="showscreen">
        <!-- TODO: live search --> 
        <section class="searchbar">
            <form id = "search-form">  <!--handling form in the same file-->  
                <input type="text" id="search-input" placeholder="Input product name..." name="search" size="50">
                <img src="images/search.png" alt="Search icon">
            </form>
            <!-- Suggestions dropdown -->
            <div id="livesearch-box" class="suggestion-box"></div>
        </section>
        <section class="product-list">
            <!-- Show the products from AJAX-->

        </section>
    </section>
</section>

