<?php
$products_per_page = 12;

// Get the current page from the URL (default is 1 if not set)
$current_page = isset($_GET['pagenum']) ? (int)$_GET['pagenum'] : 1;
if ($current_page < 1) $current_page = 1;

// Get search query, filter, sort
$search = isset($_GET['search'])? trim($mydatabase->real_escape_string($_GET['search'])) : ''; //trim whitespace and escape special characters
$seleceted_cat = isset($_GET['category'])? $_GET['category'] : [];
$selected_sort = isset($_GET['sort'])? $_GET['sort'] : 'none';


$user_query = "SELECT * FROM product WHERE 1";  //select all products by default, before adding other conditions 

// Apply search query
if (!empty($search)) {
    $user_query .= " AND name LIKE '%$search%'";  //match anything after and before the search input
}

// Apply category filter
if (!empty($seleceted_cat)) {
    $selected_cat = array_map("intval", $seleceted_cat ); //Ensure the selected categories are integer
    $category_list = implode(",", $selected_cat);  //convert array for query
    $user_query .= " AND category_id IN ($category_list)";
}

// Apply sort
switch ($selected_sort) {
    case 'name-asc':
        $user_query .= " ORDER BY name ASC";
        break;
    case 'name-desc':
        $user_query .= " ORDER BY name DESC";
        break;
    case 'price-asc':
        $user_query .= " ORDER BY price ASC";
        break;
    case 'price-desc':
        $user_query .= " ORDER BY price DESC";
        break;
    default:
        break;
}

// Get total number of results of search, filter, sort
$total_result = $mydatabase->query("SELECT COUNT(*) AS total FROM ($user_query) AS filtered");  //subquery need a name
$total_result = $total_result->fetch_assoc()['total'];

// Pagination
$total_pages = ceil($total_result / $products_per_page);
$start_item = ($current_page - 1) * $products_per_page;
$user_query .= " LIMIT $start_item, $products_per_page";

// Get the items to display
$items = $mydatabase->query($user_query);
?>

<div class="container">
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
                            // check if the category was previously selected by the user
                            $checked = in_array($category_id, $seleceted_cat)? "checked" : "";
                    ?>
                    <div>  <!-- Create a checkbox for each category and an array for category selection -->
                        <input type="checkbox" name="<?="category[]"?>" value="<?=$category_id?>" <?=$checked?>>
                        <label><?php echo ucfirst($category_name); ?></label>
                    </div>
                    <?php } ?>
                </div>

            <div class="sort">
                <p>Sort</p>
                <div class="sort-option">
                    <select name="sort"> <!-- "selected" attribute is used to show the selected option -->
                        <option  value="none" <?=($selected_sort == "none")? "selected" : ""?>>
                            None
                        </option>
                        <option value="name-asc" <?=($selected_sort == "name-asc")? "selected" : ""?>>
                            Name: A to Z</option>
                        <option value="name-desc" <?=($selected_sort == "name-desc")? "selected" : ""?>>
                            Name: Z to A
                        </option>
                        <option value="price-asc" <?=($selected_sort == "price-asc")? "selected" : ""?>>
                            Price: Low to High
                        </option>
                        <option value="price-desc" <?=($selected_sort == "price-desc")? "selected" : ""?>>
                            Price: High to Low
                        </option>
                    </select>
                </div>
            </div><br><br>
            
            <button type="submit" class="applybtn">
                Apply
            </button>
        </form>

        <br><button class="showall-btn" onclick="window.location.href='index.php?page=products';">
            Show All
        </button>

        <div>
            <p>Results</p><hr>  <!--show the number of results-->
            <p class="result"><?=$total_result?> products found</p>
        </div>
    </div>

    <div class="showscreen">
        <!-- TODO: live search --> 
        <div class="searchbar">
            <form action="index.php?page=products" method="GET">  <!--handling form in the same file-->
                <input type="hidden" name="page" value="products">  <!-- Ensures 'page=products' is always included -->
                
                <!-- Combine with filter and sort -->
                <?php foreach ($seleceted_cat as $cat_id) {?>
                    <input type="hidden" name="category[]" value="<?= $cat_id ?>">
                <?php } ?>
                <input type="hidden" name="sort" value="<?= htmlspecialchars($selected_sort) ?>">
                
                <input type="text" placeholder="Input product name..." name="search" value="<?= htmlspecialchars($search) ?>">
                <button type="submit">
                    <img src="images/search.png" alt="Search icon">
                </button>
            </form>
        </div>

        <?php
        if ($items->num_rows == 0) {
            echo "
            <h3 class=\"showscreen noitem\">
                NO PRODUCT AVAILABLE!
            </h3>
            ";
        }
        else {                        
        ?>

        <div class="card-zone">
            <?php
                while ($row = $items->fetch_assoc()) {
                    $name = $row['name'];
                    $price = number_format($row['price'], 0, '.', ',');
                    $type_name = $mydatabase->query("SELECT name FROM category WHERE id = " .$row['category_id'])->fetch_assoc()['name']; //get the type name from category table
                    $image_path = "images/$type_name/" .$row['image'];
                    
            ?>

            <div class="card">
                <img src="<?=$image_path?>" alt="<?=$name?>" style="object-fit: fill;">
                <div class="card-info">
                    <h4><?=$name?></h4>
                    <p><?=$price?> &nbsp; VND</p>
                </div>
                <div>
                    <button class="viewdetail"  onclick="window.open('index.php?page=detail&name=<?=urlencode($name)?>&productId=<?=$row['id']?>', '_blank')">
                        View detail
                    </button>
                </div>
                <div>
                    <!-- Add to cart -->
                    <button class="addtocart" title="Add to Cart" onclick="">
                        <img src="images/add-cart.png" alt="Add to Cart">
                    </button>
                </div>
            </div>
            <?php } ?>
        </div>

        <div class="page-number">
            <?php if ($current_page > 1) { ?>
                    <a href="index.php?page=products&pagenum=<?=$current_page-1?>">
                        <img src="images/left-arrow.png" alt="Previous">
                    </a>
            <?php } ?>

            <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
                <div class="number <?=($i==$current_page)? 'active':''?>">
                    <a href="index.php?page=products&pagenum=<?=$i?>" class="<?=($i==$current_page)? 'active':''?>">
                        <?=$i?>
                    </a>
                </div>
            <?php } ?>

            <?php if ($current_page < $total_pages) { ?>
                    <a href="index.php?page=products&pagenum=<?=$current_page+1?>">
                        <img src="images/right-arrow.png" alt="Next">
                    </a>
            <?php } ?>
        </div>
        <?php } ?>
    </div>
</div>
