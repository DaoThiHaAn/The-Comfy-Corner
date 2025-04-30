<?php
session_start();
$mydatabase = new mysqli("localhost", "root", "", "houseware_store");

if ($mydatabase->connect_error) {
    die("Connection failed: " . $mydatabase->connect_error);
}

// Get search and filter parameters
$search = isset($_GET['search']) ? "%" . $mydatabase->real_escape_string($_GET['search']) . "%" : "%%";
$category = isset($_GET['category']) && $_GET['category'] !== "all" ? intval($_GET['category']) : null;
$page = isset($_GET['pagenum']) ? max(1, intval($_GET['pagenum'])) : 1;
$limit = 10; // Products per page
$offset = ($page - 1) * $limit;

// Get sorting parameter
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'none';

// Build the query
$query = "SELECT p.*, c.name as category_name FROM product p 
          LEFT JOIN category c ON p.category_id = c.id 
          WHERE p.name LIKE ?";
$params = ["s", $search];

if ($category) {
    $query .= " AND p.category_id = ?";
    $params[0] .= "i";
    $params[] = $category;
}

// Modify the query based on the sorting option
switch ($sort) {
    case 'name-asc':
        $query .= " ORDER BY p.name ASC";
        break;
    case 'name-desc':
        $query .= " ORDER BY p.name DESC";
        break;
    case 'price-asc':
        $query .= " ORDER BY p.price ASC";
        break;
    case 'price-desc':
        $query .= " ORDER BY p.price DESC";
        break;
    default:
        $query .= " ORDER BY p.id DESC"; // Default sorting
        break;
}

$query .= " LIMIT ? OFFSET ?";
$params[0] .= "ii";
$params[] = $limit;
$params[] = $offset;

// Prepare and execute the query
$stmt = $mydatabase->prepare($query);
$stmt->bind_param(...$params);
$stmt->execute();
$products = $stmt->get_result();

// Fetch total count for pagination
$countQuery = "SELECT COUNT(*) as count FROM product p 
               LEFT JOIN category c ON p.category_id = c.id 
               WHERE p.name LIKE ?";
$countParams = ["s", $search];

if ($category) {
    $countQuery .= " AND p.category_id = ?";
    $countParams[0] .= "i";
    $countParams[] = $category;
}

$countStmt = $mydatabase->prepare($countQuery);
$countStmt->bind_param(...$countParams);
$countStmt->execute();
$totalRows = $countStmt->get_result()->fetch_assoc()['count'];
$totalPages = ceil($totalRows / $limit);

// Generate the HTML for the products table
$html = "";
$i = $offset + 1;
while ($row = $products->fetch_assoc()) {
    $html .= "<tr>
                <td>{$i}</td>
                <td><a class='cell-name' href='{$_SESSION['base_url']}detail/" . urlencode($row['name']) . "/{$row['id']}' title='Click to view product display'>" 
                    . htmlspecialchars($row['name']) . "<span>&nbsp;&nbsp;<i class='fa-solid fa-up-right-and-down-left-from-center'></i></span>" 
                . "</a></td>
                <td>" . htmlspecialchars($row['category_name']) . "</td>
                <td>" . number_format($row['price']) . "</td>
                <td>{$row['stock_quantity']}</td>
                <td class='action-btn'>
                    <a href='{$_SESSION['base_url']}edit_product/{$row['id']}' class='btn modify' title='Edit'>
                        <i class='fa-regular fa-pen-to-square'></i>
                    </a>
                    <a class='btn delete' href='#' data-id='{$row['id']}' title='Delete'>
                        <i class='fa-solid fa-trash'></i>
                    </a>
                </td>   
              </tr>";
    $i++;
}

// Generate the HTML for pagination
$pagination = "";
$maxVisiblePages = 5; // Maximum number of visible page links

if ($page > 1) {
    $pagination .= "<a href='#' class='pagination-link' data-page='" . ($page - 1) . "'>&laquo; Prev</a>";
}

// Determine the range of pages to display
$startPage = max(1, $page - floor($maxVisiblePages / 2));
$endPage = min($totalPages, $startPage + $maxVisiblePages - 1);

// Adjust the start page if the end page is too close to the total pages
if ($endPage - $startPage + 1 < $maxVisiblePages) {
    $startPage = max(1, $endPage - $maxVisiblePages + 1);
}

// Add the first page and ellipses if necessary
if ($startPage > 1) {
    $pagination .= "<a href='#' class='pagination-link' data-page='1'>1</a>";
    if ($startPage > 2) {
        $pagination .= "<span class='pagination-ellipsis'>...</span>";
    }
}

// Add the visible page links
for ($i = $startPage; $i <= $endPage; $i++) {
    $active = $i == $page ? "active" : "";
    $pagination .= "<a href='#' class='pagination-link $active' data-page='$i'>$i</a>";
}

// Add the last page and ellipses if necessary
if ($endPage < $totalPages) {
    if ($endPage < $totalPages - 1) {
        $pagination .= "<span class='pagination-ellipsis'>...</span>";
    }
    $pagination .= "<a href='#' class='pagination-link' data-page='$totalPages'>$totalPages</a>";
}

// Add the "Next" button
if ($page < $totalPages) {
    $pagination .= "<a href='#' class='pagination-link' data-page='" . ($page + 1) . "'>Next &raquo;</a>";
}

// Return the response as JSON
if ($html == "") {
    $html = "<tr><td colspan='7'>No matching products found.</td></tr>";
}
echo json_encode(["html" => $html, "pagination" => $pagination]);
?>