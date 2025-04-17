<?php
$products_per_page = 12;

// Get the current page from the URL (default is 1 if not set)
$current_page = isset($_GET['pagenum']) ? (int)$_GET['pagenum'] : 1;
if ($current_page < 1) $current_page = 1;

// Get search query, filter, sort
$search = isset($_GET['search'])? trim($mydatabase->real_escape_string($_GET['search'])) : ''; //trim whitespace and escape special characters
$selected_cat = isset($_GET['category'])? $_GET['category'] : []; // corrected variable name
$selected_sort = isset($_GET['sort'])? $_GET['sort'] : 'none';

$user_query = "SELECT * FROM product WHERE 1";  //select all products by default, before adding other conditions 

// Apply search query
if (!empty($search)) {
    $user_query .= " AND name LIKE '%$search%'";  //match anything after and before the search input
}

// Apply category filter
if (!empty($selected_cat)) {
    $selected_cat = array_map("intval", $selected_cat ); //Ensure the selected categories are integer
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

if ($items->num_rows == 0) {
    echo "
    <h3 class=\"showscreen noitem\">
        NO PRODUCT AVAILABLE!
    </h3>
    ";
}
else {

echo "<section class='card-zone'>";
        while ($row = $items->fetch_assoc()) {
            $name = $row['name'];
            $price = number_format($row['price'], 0, '.', ',');
            $type_name = $mydatabase->query("SELECT name FROM category WHERE id = " .$row['category_id'])->fetch_assoc()['name']; //get the type name from category table
            $image_path = "images/$type_name/" .$row['image'];                    

    echo "
    <div class='card'>
        <img src='".$image_path."' alt='".$name."' style='object-fit: fill;'>
        <div class='card-info'>
            <h4><?=$name?></h4>
            <p><?=$price?> &nbsp; VND</p>
        </div>
        <div>
            <button class='viewdetail' 
                onclick='window.open('index.php?page=detail&name=".urlencode($name)."&productId=".$row['id']."', '_blank')'>
                View detail
            </button>
        </div>

        <div>";
        if ($_SESSION['role'] == 'guest') {
            echo  "<button class='addtocart' title='Add to Cart' onclick='openLoginRequiredDialog()\"'>
                <img src='images/add-cart.png' alt='Add to Cart'>
            </button>";
        }
        else if ($_SESSION['role'] == 'user') {
        echo  "<button class='addtocart' title='Add to Cart' 
        onclick='window.href.location=\"index.php?page=addtocart&productId=".$row['id']."\"'>
                <img src='images/add-cart.png' alt='Add to Cart'>
            </button>";
        }
        echo "</div>
    </div>";
        } 
echo "</section>";

// Pagination
echo "<div class='page-number'>";
    if ($current_page > 1) {
        echo "
            <a href=\"index.php?page=products&pagenum=" . ($current_page-1) . "\">
                <img src=\"images/left-arrow.png\" alt=\"Previous\">
            </a>";
    }

    for ($i = 1; $i <= $total_pages; $i++) {
        echo "
        <div class=\"number " . (($i==$current_page)? 'active':'') . "\">
            <a href=\"index.php?page=products&pagenum=" . $i . "\" class=\"" . (($i==$current_page)? 'active':'') . "\">
                " . $i . "
            </a>
        </div>";
    }

    if ($current_page < $total_pages) { 
        echo "<a href=\"index.php?page=products&pagenum=" . ($current_page+1) . "\">
                <img src=\"images/right-arrow.png\" alt=\"Next\">
            </a>";
    } 
echo "</div>";
}
echo "</div>
    </div>";
?>