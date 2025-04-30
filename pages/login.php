<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$username_email = $password = "";
if ($_SERVER["REQUEST_METHOD"] =="POST") {
    $username_email = test_input($_POST["uname-email"]);
    $password = test_input($_POST["password"]);

    $stmt = $mydatabase->prepare("SELECT username, email, role, password FROM account WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $username_email, $username_email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            openDialog(['Your username or email does not exist!', 'Register now']);
        });
        </script>";
    }
    else {
        $result = $result->fetch_assoc();
        $hashed_password = $result["password"];
        if (password_verify($password, $hashed_password)) {
            $_SESSION['username'] = $result["username"]; 
            $_SESSION['email'] = $result["email"];
            $_SESSION['role'] = $result["role"];
            if ($result["role"]== 'user') {
                $_SESSION['cartId'] = $mydatabase->query("SELECT id FROM cart WHERE username = '{$_SESSION['username']}'")->fetch_assoc()['id'];
            }

            echo "<script>
            console.log('Login successfully!');
            window.location.href = 'home';
            </script>";
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

        <form action="<?=$_SESSION['base_url']?>login" method="POST">                    
            <input class="username" type="text" placeholder="Email or username" name="uname-email" 
            value="<?=htmlspecialchars($username_email)?>" autocomplete="username" required>
            
            <div class="password-container">
                <input class="password" type="password" placeholder="Password" name="password" 
                value="<?=htmlspecialchars($password)?>" autocomplete="current-password" required>
                <!-- Show/Hide password + change the icon -->
                <img src="<?=$_SESSION['base_url']?>images/visible.png" class="toggle-password" width="20" height="20" alt="visible icon" onclick="togglePassword(this)">
            </div>

            <button type="submit">
                Sign In
            </button>
        </form>

        <a class="forgot-password" href="forgotpssw">Forgot password?</a>

        <p>Don't have an account? &nbsp;
            <span> <a href="signup">Register Now</a></span>
        </p>
    </div>
</div>
