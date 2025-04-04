<section class="mgnt-container">
    <button class="toggle-drawer-btn" onclick="toggleDrawer()">☰ Menu</button>
    
    <section class="drawer">
        <img src="images/logo-text.jpg" alt="Logo" class="logo">
        <h3>Product Management</h3>
        <hr>
        <a
            href="index.php?page=productmgnt&tab=view_all_products"
            class="drawer-link <?= (isset($_GET['tab']) && $_GET['tab']=='view_all_products') ? 'item-active' : '' ?>">
            View all products
        </a>
        <a
            href="index.php?page=productmgnt&tab=add_product"
            class="drawer-link <?= (isset($_GET['tab']) && $_GET['tab']=='add_product') ? 'item-active' : '' ?>">
            Add new product
        </a>
    </section>

    <section class="action-screen">
        <?php
        if (isset($_GET['tab'])) {
            include $_GET['tab'] . '.php';
        } 
        ?>
    </section>    
</section>