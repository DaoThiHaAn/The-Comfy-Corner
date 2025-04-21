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
$totalProducts = $mydatabase->query("SELECT COUNT(*) AS total_products FROM product")->fetch_assoc()['total_products'];

$productColors = [];
$hueStep = 360 / count($productTypes); // Divide the hue spectrum evenly
for ($i = 0; $i < count($productTypes); $i++) {
    $hue = $i * $hueStep; // Calculate the hue for each category
    $productColors[] = "hsl($hue, 60%, 50%)"; // Use 70% saturation and 50% lightness for balanced colors
}
?>

<h1>📊 Data Analysis</h1>

<div class="card">
    <h3>Total Users: <span><?php echo $totalUsers; ?></span></h3>
    <h3>Total Products: <span><?php echo $totalProducts; ?></span></h3>

    <div class="charts">
    <div>
        <h3 style="color: var(--dark-pink);">Product Type Distribution</h3>
        <canvas id="productChart"></canvas>
    </div>
</div>

<script>
    const productTypes = <?php echo json_encode($productTypes); ?>;
    const productCounts = <?php echo json_encode($productCounts); ?>;
    const productColors = <?php echo json_encode($productColors); ?>; // Pass consistent colors to JavaScript

    const generateColors = (count) => {
        const colors = [];
        for (let i = 0; i < count; i++) {
            const color = `#${Math.floor(Math.random() * 16777215).toString(16).padStart(6, '0')}`; // Generate random hex color
            colors.push(color);
        }
        return colors;
    };

    const productCtx = document.getElementById('productChart').getContext('2d');
    const productChart = new Chart(productCtx, {
        type: 'pie',
        data: {
            labels: productTypes,
            datasets: [{
                label: 'Number of items',
                data: productCounts,
                backgroundColor: productColors,
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                datalabels: {
                    formatter: (value, context) => {
                        const total = context.chart.data.datasets[0].data.reduce((a, b) => parseFloat(a) + parseFloat(b), 0);
                        const percentage = ((value / total) * 100).toFixed(1); // Calculate percentage
                        return percentage + '%'; // Display percentage
                    },
                    color: '#fff', // Text color
                    font: {
                        weight: 'bold',
                        size: 14
                    }
                }
            }
        },
        plugins: [ChartDataLabels] // Enable the Data Labels plugin
    });
</script>

</div>

