<?php 
if  ($_SERVER['REQUEST_METHOD'] == "POST") {
    $email = test_input($_POST['email']);
    if (isEmailExist($email, $mydatabase)) {
        $message = "
        <html>
            <head>
                <title>Reset Password</title>
            </head>
            <body>
                <h1>Reset Password</h1><br>
                <p>Click the link below to reset your password:</p>
                <a href='$base_url/index.php?page=resetpssw'>
                    <h3>Reset Password</h3>
                </a>
            </body>
        </html>
        ";
        if (sendEmail($email, "THE COMFY CORNER: Reset password request", $message)) {
            $_SESSION['email'] = $email;
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    openDialog(['Please check your email (including the spam folder) for a link to reset your password!']);
                });
            </script>";
        } else {
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    openDialog(['Failed to send email!', 'Please try again.']);
                });
            </script>";
        }
    }
    else {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                openDialog(['Email is not registered!', 'Please register an account.']);
            });
        </script>";
    }
}

?>

<div class="signin-container">
    <div class="form-container">
        <div class="form-header">
            <p class="p1">Forgot passwords?</p>
            <p class="p2">Please enter your email to reset your password.</p>
        </div>

        <form action="<?=$_SERVER['PHP_SELF'].'?page=forgotpssw'?>" method="POST">                    
            <input type="email" placeholder="Email" name="email" required>
            <button type="submit">
                Continue 
                &nbsp; &nbsp; <img src="images/right-arrow-white.png" alt="right-arrow" width="25" height="25">
            </button>
        </form>

        <p>Don't have an account? &nbsp;
            <span> <a href="index.php?page=signup">Register Now</a></span>
        </p>
    </div>
</div>

