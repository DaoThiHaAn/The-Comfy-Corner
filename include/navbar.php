<nav class="navbar" id="navbar">
    <div class="openmenu" onclick="openMenu()">
        <img src="images/list-view.png" alt="Open Menu" width="25">
    </div>

    <div href="index.php?page=home" class="shopname-container">
        <img src="images/logo.jpg" alt="Logo" height="30px">
        <span>The Comfy Corner</span>
    </div>

    <div>
        <a id="homebtn" href="index.php?page=home" class="<?=($page=='home')? 'active':''?>">
            <img id="homeicon" 
            src="images/<?php echo ($page == 'home') ? 'home-hover.png' : 'home.png'; ?>"
            alt="Home">
        &nbsp;Home
        </a>
    </div>

    <!-- Set the UI according to user role -->
<?php
if ($_SESSION['role'] == 'admin') {
    $img_profile = "images/admin-profile.png"; 
?>
    <div>
        <a href="index.php?page=dashboard" class="<?=($page=='dashboard')?'active':''?>">
            Dashboard
        </a>
    </div>
<?php } else {?>
    <div>
        <a href="index.php?page=products" class="<?=($page=='products')?'active':''?>">
            Products
        </a>
    </div>

    <div class="dropdown">
        <a class="dropbtn">Categories</a>
        <!-- extract category from database -->
        <div class="dropdown-content">
            <?php
            $categories = $mydatabase->query("SELECT * FROM category");
            while ($row = $categories->fetch_assoc()) {
                $category_name = ucwords($row['name']);
                $category_id = $row['id'];
                echo "<a href=\"index.php?page=products&category[]={$category_id}\">$category_name</a>";
            }
            ?>
        </div>
    </div>
    <?php } ?>
    <div>
        <a href="index.php?page=contact" class="<?=($page=='contact')?'active':''?>">Contact</a>
    </div>

    
    <?php if ($_SESSION['role'] == 'guest') {?>
    <section class="signinup-btn">
        <button class="signin-btn" onclick="window.open('index.php?page=login', '_self')">
            Log in
            <img src="images/enter.png" alt="Enter icon">
        </button>
        <button class="signup-btn" onclick="window.open('index.php?page=signup', '_self')">
            Sign up
        </button>
    </section>
    <?php } else { 
    if ($_SESSION['role'] == 'user') {
        $img_profile = "images/profile.png"; 
    }    
    ?>
    <section class="cart-account">
        <div class="dropdown account-navbar <?=$_SESSION['role'] == 'admin' ? 'admin' : ''?>">
            <a class="dropbtn account">
                <img src="<?=$img_profile?>" alt="User icon">
                <?=$_SESSION['username']?>
            </a>
            <div class="dropdown-content">
                <a href="index.php?page=profile">View Profile</a>
                <a  onclick='openLogoutDialog()'>
                    <div class="logout">
                        Logout
                        <img src="images/logout.png" alt="Logout icon">
                    </div>
                </a>
            </div>
        </div>

        <?php if ($_SESSION['role'] == 'user') { ?>
        <div class="cart-navbar">
            <button class="cart-btn <?=($page=='cart')?'active':''?>" onclick="window.location.href='index.php?page=cart_view'" title="Click to view your cart">
                <img class="cart" src="images/cart.png" alt="Cart icon">
            </button>
        </div>
    </section>
    
    <?php } 
    }?>
</nav>  