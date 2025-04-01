<?php
$password = "";
if ($_SERVER["REQUEST_METHOD"] =="POST") {
    $email = $_SESSION['email'];
    $password = test_input($_POST["password"]);
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    $stmt = $mydatabase->prepare("UPDATE account SET password = ? WHERE email = ?");
    $stmt->bind_param("ss", $hashed_password, $email);
    
    if($stmt->execute()) {
        session_unset();
        session_destroy();
        echo "<script>
            alert('Password reset successfully! \\nPlease login to continue');
            window.location.href = 'index.php?page=login';
            console.log('Password reset successfully!');
        </script>";
    }
    else {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                openDialog(['Failed to reset password! Please try again.']);
            });
        </script>";
    }
}

?>

<div class="signin-container">
    <div class="form-container">
        <div class="form-header">
            <p class="p1">Reset Password</p>
            <p class="p2">Please enter your new password below:</p>
        </div>

        <form class="reset-form" action="<?=$_SERVER['PHP_SELF'].'?page=resetpssw'?>" method="POST">                                
        <div class="password-container">
                <input class="password" type="password" placeholder="Password" name="password" required>
                <!-- Show/Hide password + change the icon -->
                <img src="images/visible.png" class="toggle-password" 
                width="20" height="20" alt="visible icon" onclick="togglePassword(this)">
            </div>

            <div class="acc-requirement">
                <p>Password must include:</p>
                <ul>
                <!-- Check password requirement  -->
                    <li class="pssw-len invalid">at least 8 characters</li>
                    <li class="pssw-char invalid">both letter(s) and digit(s) and (or) special characters:<br>
                        ., !, @, #, $, %, ^, &, * </li>
                </ul>
            </div>
            <div class="password-container">
                <input class="password-cf invalid-border" type="password" placeholder="Confirm password" name="password-cf" required>
                <!-- Show/Hide password + change the icon -->
                <img src="images/visible.png" class="toggle-password-cf"
                width="20" height="20" alt="visible icon" onclick="togglePassword(this)">
            </div>

            <button type="submit">
                Continue 
                &nbsp; &nbsp; <img src="images/right-arrow-white.png" alt="right-arrow" width="25" height="25">
            </button>
        </form>
    </div>
</div>

