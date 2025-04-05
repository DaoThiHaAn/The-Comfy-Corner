<?php
// Total users
$userQuery = $mydatabase->query("SELECT COUNT(*) AS total_users FROM account WHERE role != 'admin'");
$totalUsers = $userQuery->fetch_assoc()['total_users'];

// Product distribution
$productQuery = $mydatabase->query("
    SELECT c.name AS category_name, COUNT(*) AS total
    FROM product p
    JOIN category c ON p.category_id = c.id
    GROUP BY c.name");

$productTypes = [];
$productCounts = [];

while ($row = $productQuery->fetch_assoc()) {
    $productTypes[] = $row['category_name'];
    $productCounts[] = $row['total'];
}
?>

<h1>📊 Data Analysis</h1>

<div class="card">
    <h3>Total Users: <span><?php echo $totalUsers; ?></span></h3>

    <div class="charts">
    <div>
        <h3>Product Type Distribution</h3>
        <canvas id="productChart"></canvas>
    </div>
</div>

<script>
        const productCtx = document.getElementById('productChart').getContext('2d');
        const productChart = new Chart(productCtx, {
            type: 'pie',
            data: {
                labels: <?php echo json_encode($productTypes); ?>,
                datasets: [{
                    label: 'Product Types',
                    data: <?php echo json_encode($productCounts); ?>,
                    backgroundColor: [
                        '#ff6384', '#36a2eb', '#ffcd56', '#4bc0c0', '#9966ff'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true
            }
        });
</script>

</div>

