<nav class="navbar" id="navbar">
    <div class="openmenu" onclick="openMenu()">
        <img src="<?=$_SESSION['base_url']?>images/list-view.png" alt="Open Menu" width="25">
    </div>

    <div href="<?=$_SESSION['base_url']?>home" class="shopname-container">
        <img src="<?=$_SESSION['base_url']?>images/logo.jpg" alt="Logo" height="30px">
        <span>The Comfy Corner</span>
    </div>

    <div>
        <a id="homebtn" href="<?=$_SESSION['base_url']?>home" class="<?=($page=='home')? 'active':''?>">
            <img id="homeicon" 
            src="<?=$_SESSION['base_url']?>images/<?php echo ($page == 'home') ? 'home-hover.png' : 'home.png'; ?>"
            alt="Home">
        &nbsp;Home
        </a>
    </div>

    <!-- Set the UI according to user role -->
<?php
if ($_SESSION['role'] == 'admin') {
    $img_profile = $_SESSION['base_url']."images/admin-profile.png"; 
?>
    <div>
        <a href="<?=$_SESSION['base_url']?>dashboard" class="<?=($page=='dashboard')?'active':''?>">
            Dashboard
        </a>
    </div>
<?php } else { ?>
    <div>
        <a href="<?=$_SESSION['base_url']?>products" class="<?=($page=='products')?'active':''?>">
            Products
        </a>
    </div>

    <div class="dropdown">
        <a class="dropbtn">
            Categories &nbsp;
            <span><i class="fa-solid fa-sm fa-angle-down"></i></span>
        </a>
        <!-- extract category from database -->
        <div class="dropdown-content">
            <?php
            $categories = $mydatabase->query("SELECT * FROM category");
            while ($row = $categories->fetch_assoc()) {
                $category_name = ucwords($row['name']);
                $category_id = $row['id'];
                echo "<a href=\"{$_SESSION['base_url']}products?category[]={$category_id}\">$category_name</a>";
            }
            ?>
        </div>
    </div>
    <?php } ?>
    <div>
        <a href="<?=$_SESSION['base_url']?>contact" class="<?=($page=='contact')?'active':''?>">Contact</a>
    </div>

    
    <?php if ($_SESSION['role'] == 'guest') {?>
    <section class="signinup-btn">
        <button class="signin-btn" onclick="window.open('<?=$_SESSION['base_url']?>login', '_self')">
            Log In
            <img src="<?=$_SESSION['base_url']?>images/enter.png" alt="Enter icon">
        </button>
        <button class="signup-btn" onclick="window.open('<?=$_SESSION['base_url']?>signup', '_self')">
            Sign Up
        </button>
    </section>
    <?php } else { 
    if ($_SESSION['role'] == 'user') {
        $img_profile = $_SESSION['base_url']."images/profile.png"; 
    }    
    ?>
    <section class="cart-account">
        <div class="dropdown account-navbar <?=$_SESSION['role'] == 'admin' ? 'admin' : ''?>">
            <a class="dropbtn account">
                <img src="<?=$img_profile?>" alt="User icon">
                <?=$_SESSION['username']?>&nbsp;
                <span><i class="fa-solid fa-sm fa-angle-down"></i></span>
            </a>
            <div class="dropdown-content">
                <a href="<?=$_SESSION['base_url']?>profile">View Profile</a>
                <?php if ($_SESSION['role'] == 'user') { ?>
                <a href="<?=$_SESSION['base_url']?>order_history">Order History</a>
                <?php } ?>
                <a  onclick='openLogoutDialog()' class="logout-btn">
                    <div class="logout">
                        Logout
                        <img src="<?=$_SESSION['base_url']?>images/logout.png" alt="Logout icon">
                    </div>
                </a>
            </div>
        </div>

        <?php if ($_SESSION['role'] == 'user') { ?>
        <div class="cart-navbar">
            <button class="cart-btn <?=($page=='cart')?'active':''?>" onclick="window.location.href='<?= $_SESSION['base_url'] ?>cart_view'" title="Click to view your cart">
                <img class="cart" src="<?=$_SESSION['base_url']?>images/cart.png" alt="Cart icon">
            </button>
        </div>
    </section>
    
    <?php } 
    }?>
</nav>  