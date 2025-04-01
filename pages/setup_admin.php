<?php
// init the first admin account
$configFile = __DIR__ . "\\admin_config.php";
if (file_exists($configFile)) {
    exit();
}

// Step 1: Check if admin already exists
$result = $mydatabase->query("SELECT COUNT(*) as admin_count FROM account WHERE role = 'admin'");
if (!$result) {
    die("Error checking admin account: " . $mydatabase->error);
}

$row = $result->fetch_assoc();
if ($row['admin_count'] > 0) {
    // Create setup flag
    file_put_contents($configFile, "<?php define('ADMIN_SETUP', true);");
}

// Step 2: Create admin account
$hashed_password = password_hash("Admin123", PASSWORD_BCRYPT);
$query = "INSERT INTO account (fname, lname, email, username, password, role) VALUES ('An', 'Dao', 'caothikimloan@gmail.com', 'admin', '$hashed_password', 'admin')";
$result = $mydatabase->query($query);

if ($result) {
    // Step 3: Mark setup as complete
    file_put_contents($configFile, "<?php define('ADMIN_SETUP', true);");
    echo "<script>console.log('Admin account created successfully!');</script>";
} else {
    echo "Error creating admin account: " . $mydatabase->error;
}

?>