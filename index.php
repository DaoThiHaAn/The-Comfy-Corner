<?php
session_start();
if (!isset($_SESSION['role']))
    $_SESSION['role'] = 'guest'; // Default role for all users before logging in
$mydatabase = new mysqli("localhost", "root", "", "houseware_store");   
if ($mydatabase->connect_error) {
    die("Connection failed:".$mydatabase->connect_error);
}

$_SESSION['database'] = $mydatabase;

// Check setup flag to initialize the first admin account
if (!defined('ADMIN_SETUP') && !file_exists(__DIR__ . "\\pages\\admin_config.php")) {
    include("pages/setup_admin.php");
}

// Automatically get the base URL no matter where the folder is
$base_url = "http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME'])."/";

// Get the page parameter, default to 'home' if not set 
$page = isset($_GET['page']) ? $_GET['page']: 'home';

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function isEmailExist($email, $database): bool {
    $stmt = $database->prepare("SELECT email FROM account WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 1) {
        return true;
    }
    return false;
}

function sendEmail($to, $subject, $message) :bool {
    $headers = "MIME-Version: 1.0\r\n"
                ."Content-type:text/html;charset=UTF-8\r\n"
                ."From: daothihaan@gmail.com\r\n"
                ."X-Priority: 1 (Highest)\n"
                ."X-MSMail-Priority: High\n"
                ."Importance: High\n";

    return mail($to, $subject, $message, $headers);
}

function fetchUsername($loginname):string {
    global $mydatabase;
    if (strpos($loginname, '@') !== false) {
        return $mydatabase->query("SELECT username, role FROM account WHERE email = '$loginname'")->fetch_assoc()['username'];
    }
    return $loginname;
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>The Comfy Corner</title>

        <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js" defer></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <link rel="stylesheet" href="css/style(index).css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Patrick Hand">
        <script src="https://kit.fontawesome.com/e38d7f03e0.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>

        <?php
        if (isset($_GET['tab'])) {
            echo "<link rel='stylesheet' href='css/style({$_GET['tab']}).css'>";
        } ?>

    <!-- SEO -->
        <meta name="description" content="The Comfy Corner - One-stop shop for all your homeware needs. Discover a wide range of products to make your home cozy and stylish.">
        <meta name="keywords" content="houseware, store, comfy, corner, products, shopping, furniture, decor">
        <meta name="author" content="Dao Thi Ha An">
        <meta name="robots" content="noindex, follow">

        <script>
            const base_url = "<?php echo $base_url; ?>";
            console.log("BASE_URL:", base_url); // Debugging to check if BASE_URL is correct
        </script>    


    <!-- Link the needed css file for selected page-->
        <?php
        if (in_array($page, ['login', 'signup', 'forgotpssw','resetpssw']))
            $css_page = 'form';
        else if ($page == 'edit_profile')
            $css_page = 'profile';
        else if ($page == 'edit_product') {
            $css_page = $page;
            echo "<link rel='stylesheet' href='css/style(add_product).css'>";
            echo "<script src='js/script(add_product).js' defer></script>";
        }
        else
            $css_page = $page;
        if (file_exists("css/style($css_page).css")) {
            echo "<link rel='stylesheet' href='css/style($css_page).css'>";
        }
        ?>
    </head>

    <body>
        <button onclick="scrollToTop()" id="topbtn"></button>
        
        <?php include("include/navbar.php"); ?>

        <!-- Load the selected page -->
        <main>
        <?php
        if (file_exists("pages/$page.php")) {
            include("pages/$page.php");
        } else {
            echo "<h2>404 Page Not Found 🥲 </h2>";
        }
        ?>
        </main>


        <dialog class="dialog-container">
            <div class="dialog">
                <h3 class="dialog-header">WARNING!</h3>

                <div class="dialog-body">
                    <div class="content"></div>  <!-- Insert dialog content here -->
                    <div class="dialog-btn">
                        <button class="cancel-btn" onclick="closeDialog()">Cancel</button>
                        <button class="ok-btn" onclick="closeDialog()">OK</button>
                        <button class="signin-btn-dialog" onclick="window.location.href='index.php?page=login'">Sign in</button>
                    </div>
                </div>
            </div>
        </dialog>

        <?php include("include/footer.php"); ?>

    </body>
</html>
<script src="js/script.js"></script>
<?php
if (isset($_GET['tab'])) {
    echo "<script src='js/script({$_GET['tab']}).js'></script>";
}
if ($page == 'detail')
        echo "<script src='js/script(products).js'></script>";
echo "<script src='js/script($css_page).js'></script>";
?>


