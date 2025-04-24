<?php
$fname = $lname = $email = $username = $password = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = test_input($_POST["fname"]);
    $lname = test_input($_POST['lname']);
    $email = test_input($_POST['email']);
    $username = test_input($_POST['uname']);
    $password = test_input($_POST['password']);

    // check duplicate username, email
    $dialog_content = [];

    if (isEmailExist($email, $mydatabase)) {
        $dialog_content[] = "Email already exists!";
    }
    
    $stmt = $mydatabase->prepare("SELECT username FROM account WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 1) {
        $dialog_content[] = "Username already exists!";
    }

    if (count($dialog_content) > 0) {
        // convert the list to string
        echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            openDialog(" . json_encode($dialog_content) . ");
        });
        </script>";
    }
    else {
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $mydatabase->prepare("INSERT INTO account (fname, lname, email, username, password, role) VALUES (?, ?, ?, ?, ?, \"user\")");
        $stmt->bind_param("sssss", $fname, $lname, $email, $username, $hashed_password);
        if ($stmt->execute()) {
            // create cart
            $stmt = $mydatabase->prepare("INSERT INTO cart (username) VALUES (?)");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $message = "
            <h2>Welcome to The Comfy Corner!</h2>
            <p>Hi <b>$fname</b>,</p>
            <p>Congratulations on joining The Comfy Corner! You’re now part of a community that brings you the best shopping experience.</p>
                <p>Here’s what you can do next:</p>
                <ul>
                    <li>Browse our wide range of products and exclusive deals.</li>
                    <li>Track your orders and manage your account easily.</li>
                    <li>Enjoy personalized recommendations tailored to your preferences.</li>
                </ul>
                <p>If you have any questions, feel free to reach out to our support team anytime. We're here to ensure your shopping experience is seamless!</p>
                <br>
                <p>Happy Shopping!<br>
                    <i>The Comfy Corner's Team</i>
                </p>            "; 
            sendEmail(
                $email,
                "THE COMFY CORNER: Account created successfully",
                $message
            );      
            echo "<script>
                alert('Account created successfully! 🎉 🎉 🎉\\nPlease login to continue');
                window.location.href = 'login';
                console.log('Account created successfully!');
            </script>";                    
        } else {
            echo "<script>
                alert('Error: ".$mydatabase->error."\nPlease try again! 🥲');
            </script>";
        }
    }
}
?>

<div class="signup-container">
    <div class="form-container">
        <div class="form-header">
            <p class="p1">Register Account</p>
            <p class="p2">Hello new user! </p>
            <p class="p3">Register to continue buying process😊</p>
        </div>

        <form class="signup-form" action="signup" method="POST">
            <div class="form-element">
                <label for="fname">First name: <span style="color: red;">*</span></label>
                <input type="text" name="fname" value="<?=htmlspecialchars($fname)?>" maxlength="255" required>
            </div>

            <div class="form-element">
                <label for="lname">Last name: <span style="color: red;">*</span></label>
                <input type="text" name="lname" value="<?=htmlspecialchars($lname)?>" maxlength="255" required>
            </div>

            <div class="form-element">
                <label for="email">Email: <span style="color: red;">*</span></label>
                <input type="email" name="email" value="<?=htmlspecialchars($email)?>" maxlength="255" required>
            </div>

            <div class="form-element">
                <label for="uname">Username: <span style="color: red;">*</span></label>
                <input class="username" type="text" name="uname" value="<?=htmlspecialchars($username)?>" maxlength="255" required>
            </div>
            <div class="acc-requirement">
                <p>Username must:</p>
                <!-- Check username requirement -->
                <ul>
                    <li class="name-pattern invalid">begin with 1 letter and followed by letter(s) or digit(s) or underscore(s)</li>
                </ul>
            </div>

            <div class="form-element">
                <label for="password">Password: <span style="color: red;">*</span></label>
                <div class="password-container">
                    <input class="password" type="password" name="password" required>
                    <!-- Show/Hide password + change the icon -->
                    <img src="<?=$_SESSION['base_url']?>images/visible.png" class="toggle-password" 
                    width="20" height="20" alt="visible icon" onclick="togglePassword(this)">
                </div>
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

            <div class="form-element">
                <label for="password-cf">Confirm password: <span style="color: red;">*</span></label>
                <div class="password-container">
                    <input class="password-cf invalid-border" type="password" name="password-cf" required>
                    <!-- Show/Hide password + change the icon -->
                    <img src="<?=$_SESSION['base_url']?>images/visible.png" class="toggle-password-cf"
                    width="20" height="20" alt="visible icon" onclick="togglePassword(this)">
                </div>
            </div>

            <button type="submit">
                Create account
            </button>
        </form>

        <p>Already has an account? &nbsp;
            <span> <a href="login">Login</a></span>
        </p>
    </div>
</div>
