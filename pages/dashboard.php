<h1>Admin Dashboard</h1>

<section class="dashboard-container">
    <button onclick="window.location.href='productmgnt'">
        <img src="<?=$_SESSION['base_url']?>images/product-management.png" alt="Product Management icon">
        Product Management
    </button>

    <button onclick="window.location.href='manage_order'">
        <img src="<?=$_SESSION['base_url']?>images/procurement.png" alt="Procurement icon">
        Manage Orders
    </button>
    
    <button onclick="window.location.href='statistics'">
        <img src="<?=$_SESSION['base_url']?>images/statistics.png" alt="Statistics icon">
        Data Statistics
    </button>

    <button onclick="window.location.href='manage_user'">
        <img src="<?=$_SESSION['base_url']?>images/system-administration.png" alt="Statistics icon">
        Manage Users
    </button>
</section>