<?php
$username_email = $password = "";
if ($_SERVER["REQUEST_METHOD"] =="POST") {
    $username_email = test_input($_POST["uname-email"]);
    $password = test_input($_POST["password"]);

    $stmt = $mydatabase->prepare("SELECT username, role, password FROM account WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $username_email, $username_email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            openDialog(['Your username or email does not exit!', 'Register now']);
        });
        </script>";
    }
    else {
        $result = $result->fetch_assoc();
        $hashed_password = $result["password"];
        if (password_verify($password, $hashed_password)) {
            echo "<script>console.log('Login successfully!');</script>";
            $_SESSION['username'] = $result["username"]; // Store the username in session
            $_SESSION['role'] = $result["role"]; // Set the role to 'user' after login
            echo "<script>window.location.href = 'index.php?page=home';</script>";
        }
        else {
            echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                openDialog(['Your username or email or password is incorrect!']);
            });
            </script>";
        }
    }
}

?>

<div class="signin-container">
    <div class="form-container">
        <div class="form-header">
            <p class="p1">Sign In</p>
            <p class="p2">Welcome back!</p>
        </div>

        <form action="<?=$_SERVER['PHP_SELF'].'?page=login'?>" method="POST">                    
            <input class="username" type="text" placeholder="Email or username" name="uname-email" value="<?=htmlspecialchars($username_email)?>"required>
            
            <div class="password-container">
                <input class="password" type="password" placeholder="Password" name="password" value="<?=htmlspecialchars($password)?>" required>
                <!-- Show/Hide password + change the icon -->
                <img src="images/visible.png" class="toggle-password" width="20" height="20" alt="visible icon" onclick="togglePassword(this)">
            </div>

            <button type="submit">
                Sign In
            </button>
        </form>

        <a class="forgot-password" href="index.php?page=forgotpssw">Forgot password?</a>

        <p>Don't have an account? &nbsp;
            <span> <a href="index.php?page=signup">Register Now</a></span>
        </p>
    </div>
</div>

<div class="dialog-container">
    <div class="dialog">
        <div class="dialog-header">
            <h3>WARNING!</h3>
        </div>

        <div class="dialog-body">
            <div class="content"></div>
            <div class="login-dialog-btn">
                <button class="ok-btn" onclick="closeDialog()">OK</button>
            </div>
        </div>
    </div>
</div>


