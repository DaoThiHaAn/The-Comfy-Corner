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
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Price (VND)</th>
                    <th>Stock</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= htmlspecialchars($row['name']) ?></td>
                        <td><?= htmlspecialchars($row['category_name']) ?></td>
                        <td><?= number_format($row['price']) ?></td>
                        <td><?= $row['stock_quantity'] ?></td>
                        <td>
                            <?php if (!empty($row['image'])): ?>
                                <img src="uploads/<?= $row['image'] ?>" alt="Product Image" style="max-width: 60px;">
                            <?php else: ?>
                                No image
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="edit_product.php?id=<?= $row['id'] ?>" class="btn modify">Modify</a>
                            <a href="delete_product.php?id=<?= $row['id'] ?>" class="btn delete" onclick="return confirm('Delete this product?')">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <div class="pagination">
            <?php if ($page > 1): ?>
                <a href="?page=<?= $page - 1 ?>">&laquo; Prev</a>
            <?php endif; ?>
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <a href="?page=<?= $i ?>" class="<?= $i == $page ? 'active' : '' ?>"><?= $i ?></a>
            <?php endfor; ?>
            <?php if ($page < $total_pages): ?>
                <a href="?page=<?= $page + 1 ?>">Next &raquo;</a>
            <?php endif; ?>
        </div>
</section>