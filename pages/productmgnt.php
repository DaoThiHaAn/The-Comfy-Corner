<section class="mgnt-container">
    <button class="toggle-drawer-btn" id="toggle-drawer-btn">
        <img src="<?=$_SESSION['base_url']?>images/main-menu.png" alt="Toggle Drawer">
    </button>
    <section class="drawer">
        <img src="<?=$_SESSION['base_url']?>images/logo-text.jpg" alt="Logo" class="logo">
        <h3>Product Management</h3>
        <hr>
        <a
            href="view_all_products"
            class="drawer-link <?= (isset($_GET['tab']) && $_GET['tab']=='view_all_products') ? 'item-active' : '' ?>">
            View all products
        </a>
        <a
            href="add_product"
            class="drawer-link <?= (isset($_GET['tab']) && $_GET['tab']=='add_product') ? 'item-active' : '' ?>">
            Add new product
        </a>
    </section>

    <section class="action-screen">
        <?php
        // Set default tab to 'view_all_products' if 'tab' is not set
        $tab = isset($_GET['tab']) ? $_GET['tab'] : 'view_all_products';

        // Include the corresponding file
        include __DIR__ . '/' . $tab . '.php';
        ?>
    </section>   
</section>