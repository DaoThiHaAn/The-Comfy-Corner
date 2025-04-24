<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$mydatabase = new mysqli("localhost", "root", "", "houseware_store");
if ($mydatabase->connect_error) {
    die("Connection failed:".$mydatabase->connect_error);
}
// Define the number of rows per page
$rows_per_page = 10;

// Get the current page number from the query string (default to 1 if not set)
$current_page = isset($_GET['pagenum']) ? (int)$_GET['pagenum'] : 1;
if ($current_page < 1) $current_page = 1;

// Calculate the offset for the SQL query
$offset = ($current_page - 1) * $rows_per_page;

// Get the total number of rows
$total_rows_query = "SELECT COUNT(*) AS total FROM purchase";
$total_rows_result = $mydatabase->query($total_rows_query);
$total_rows = $total_rows_result->fetch_assoc()['total'];

// Calculate the total number of pages
$total_pages = ceil($total_rows / $rows_per_page);

// Fetch the rows for the current page
$query = "SELECT * FROM purchase ORDER BY time_create DESC LIMIT $rows_per_page OFFSET $offset";
$result = $mydatabase->query($query);
?>

<section class="container">
    <h2>Order History</h2>
    <!-- Products Table -->
    <table>
        <thead>
            <tr>
                <th></th>
                <th>Order ID</th>
                <th>Customer</th>
                <th>Total Price (VND)</th>
                <th>Time Ordered</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="products-table">
        <?php
        if ($result->num_rows == 0) {
            echo "<tr><td colspan='6'>No orders found.</td></tr>";
        } else {
            $i = 1;
            while ($row = $result->fetch_assoc()) {
                $purchaseId = $row['id'];
                $total_price = number_format($row['total_price'], 0, '.', ',');
                $time_create = $row['time_create'];
                $username = $row['username'];
        
                echo "<tr>
                        <td>" . $i++ . "</td>
                        <td>{$purchaseId}</td>
                        <td>{$username}</td>
                        <td>{$total_price} VND</td>
                        <td>{$time_create}</td>
                        <td>
                            <button class='view-btn' onclick=\"window.location.href='order_view/{$purchaseId}'\">
                                View <i class='fa fa-solid fa-eye'></i>
                            </button>
                        </td>
                      </tr>";
            }
        }
        ?>
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="pagination" id="pagination">
    <?php if ($total_pages >= 1): ?>
        <!-- Previous Page Link -->
        <?php if ($current_page > 1): ?>
            <a href="?pagenum=<?= $current_page - 1; ?>" class="page-link">Previous</a>
        <?php endif; ?>

        <!-- Page Number Links -->
        <?php
        // Define the range of pages to display
        $range = 2; // Number of pages to show before and after the current page
        $start = max(1, $current_page - $range);
        $end = min($total_pages, $current_page + $range);

        for ($i = $start; $i <= $end; $i++): ?>
            <a href="?pagenum=<?= $i; ?>" class="pagination-link <?= $i == $current_page ? 'active' : ''; ?>">
                <?= $i; ?>
            </a>
        <?php endfor; ?>

        <!-- Next Page Link -->
        <?php if ($current_page < $total_pages): ?>
            <a href="?pagenum=<?= $current_page + 1; ?>" class="pagination-link">Next</a>
        <?php endif; ?>
    <?php endif; ?>
</div>
</section>