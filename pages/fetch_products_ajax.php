<?php
session_start();
$mydatabase = new mysqli("localhost", "root", "", "houseware_store");

if ($mydatabase->connect_error) {
    die("Connection failed: " . $mydatabase->connect_error);
}

// Get search and filter parameters
$search = isset($_GET['search']) ? "%" . $mydatabase->real_escape_string($_GET['search']) . "%" : "%%";
$category = isset($_GET['category']) && $_GET['category'] !== "all" ? intval($_GET['category']) : null;
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$limit = 20; // Products per page
$offset = ($page - 1) * $limit;

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

$query .= " ORDER BY p.id DESC LIMIT ? OFFSET ?";
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
                <td>" . htmlspecialchars($row['name']) . "</td>
                <td>" . htmlspecialchars($row['category_name']) . "</td>
                <td>" . number_format($row['price']) . "</td>
                <td>{$row['stock_quantity']}</td>
                <td class='action-btn'>
                    <a href='index.php?page=edit_product&id={$row['id']}' class='btn modify' title='Edit'>
                        <i class='fa-regular fa-pen-to-square'></i>
                    </a>
                    <a href='delete_product.php?id={$row['id']}' class='btn delete' onclick='return confirm(\"Delete this product?\")' title='Delete'>
                        <i class='fa-solid fa-trash'></i>
                    </a>
                </td>
              </tr>";
    $i++;
}

// Generate the HTML for pagination
$pagination = "";
if ($page > 1) {
    $pagination .= "<a href='#' data-page='" . ($page - 1) . "'>&laquo; Prev</a>";
}
for ($i = 1; $i <= $totalPages; $i++) {
    $active = $i == $page ? "active" : "";
    $pagination .= "<a href='#' class='$active' data-page='$i'>$i</a>";
}
if ($page < $totalPages) {
    $pagination .= "<a href='#' data-page='" . ($page + 1) . "'>Next &raquo;</a>";
}

// Return the response as JSON
echo json_encode(["html" => $html, "pagination" => $pagination]);
?>