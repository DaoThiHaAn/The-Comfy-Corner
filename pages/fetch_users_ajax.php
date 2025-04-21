<?php
session_start();
$mydatabase = new mysqli("localhost", "root", "", "houseware_store");

if ($mydatabase->connect_error) {
    die(json_encode(["success" => false, "message" => "Database connection failed."]));
}

// Get role filter and pagination parameters
$role = isset($_GET['role']) && $_GET['role'] !== 'all' ? $_GET['role'] : null;
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$limit = 10; // Users per page
$offset = ($page - 1) * $limit;

// Build the query for fetching users
$query = "SELECT * FROM account WHERE 1";
$params = [];
if ($role) {
    $query .= " AND role = ?";
    $params[] = $role;
}
$query .= " LIMIT ? OFFSET ?";
$params[] = $limit;
$params[] = $offset;

// Prepare and execute the query
$stmt = $mydatabase->prepare($query);
if ($role) {
    $stmt->bind_param("sii", $params[0], $params[1], $params[2]);
} else {
    $stmt->bind_param("ii", $params[0], $params[1]);
}
$stmt->execute();
$result = $stmt->get_result();

// Fetch total count for pagination
$countQuery = "SELECT COUNT(*) as count FROM account WHERE 1";
$countParams = [];
if ($role) {
    $countQuery .= " AND role = ?";
    $countParams[] = $role;
}
$countStmt = $mydatabase->prepare($countQuery);
if ($role) {
    $countStmt->bind_param("s", $countParams[0]);
}
$countStmt->execute();
$totalRows = $countStmt->get_result()->fetch_assoc()['count'];
$totalPages = ceil($totalRows / $limit);

// Generate the HTML for the users table
$html = "";
$i = $offset + 1;
while ($row = $result->fetch_assoc()) {
    $button = '';
    if ($row['role'] == 'user') {
        $button = '<button class="assign-admin" onclick="assignAdmin(\'' . $row['username'] . '\')">Make Admin</button>';
    }
    $html .= "<tr>
                <td>{$i}</td>
                <td>" . htmlspecialchars($row['username']) . "</td>
                <td>" . htmlspecialchars($row['lname']) . "</td>
                <td>" . htmlspecialchars($row['fname']) . "</td>
                <td>" . htmlspecialchars($row['email']) . "</td>
                <td>" . htmlspecialchars($row['role']) . "</td>
                <td>
                    $button
                </td>
              </tr>";
    $i++;
}

// Generate the HTML for pagination
$pagination = "";
$maxVisiblePages = 5; // Maximum number of visible page links

if ($page > 1) {
    $pagination .= "<a href='#' data-page='" . ($page - 1) . "'>&laquo; Prev</a>";
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
    $pagination .= "<a href='#' data-page='1'>1</a>";
    if ($startPage > 2) {
        $pagination .= "<span class='pagination-ellipsis'>...</span>";
    }
}

// Add the visible page links
for ($i = $startPage; $i <= $endPage; $i++) {
    $active = $i == $page ? "active" : "";
    $pagination .= "<a href='#' class='$active' data-page='$i'>$i</a>";
}

// Add the last page and ellipses if necessary
if ($endPage < $totalPages) {
    if ($endPage < $totalPages - 1) {
        $pagination .= "<span class='pagination-ellipsis'>...</span>";
    }
    $pagination .= "<a href='#' data-page='$totalPages'>$totalPages</a>";
}

if ($page < $totalPages) {
    $pagination .= "<a href='#' data-page='" . ($page + 1) . "'>Next &raquo;</a>";
}

// Return the response as JSON
if ($html == "") {
    $html = "<tr><td colspan='7'>No matching accounts found.</td></tr>";
}
echo json_encode(["html" => $html, "pagination" => $pagination]);
?>