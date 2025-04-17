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
                        $categories = $mydatabase->query("SELECT * FROM category");
                        while ($category = $categories->fetch_assoc()) {
                            $category_name = $category['name'];
                            $category_id = $category['id'];
                    ?>
                    <div>  <!-- Create a checkbox for each category and an array for category selection -->
                        <input type="checkbox" name="<?="category[]"?>" value="<?=$category_id?>">
                        <label><?php echo ucfirst($category_name); ?></label>
                    </div>
                    <?php } ?>
                </div>

            <div class="sort">
                <p>Sort</p>
                <div class="sort-option">
                    <select name="sort"> <!-- "selected" attribute is used to show the selected option -->
                        <option  value="none">
                            None
                        </option>
                        <option value="name-asc">
                            Name: A to Z</option>
                        <option value="name-desc">
                            Name: Z to A
                        </option>
                        <option value="price-asc">
                            Price: Low to High
                        </option>
                        <option value="price-desc">
                            Price: High to Low
                        </option>
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
                <input type="text" id="search-input" placeholder="Input product name..." name="search" size="50"
                    onkeyup="showResults(this.value)">
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

