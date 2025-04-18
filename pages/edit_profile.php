<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fname = test_input($_POST['fname']);
    $lname = test_input($_POST['lname']);
    if ($fname == '')
        echo "<script>
            window.addEventListener('DOMContentLoaded', function() {
            openDialog(['First name cannot be empty!']);
            });
            </script>";
    else if ($lname == '')
        echo "<script>
            window.addEventListener('DOMContentLoaded', function() {
            openDialog(['Last name cannot be empty!']);
            });
            </script>";
    else {
        $lname = test_input($_POST['lname']);
        $fname = test_input($_POST['fname']);
        $query = "UPDATE account SET fname = ?, lname = ? WHERE username = '" .$_SESSION['username'] ."';";
        $stmt = $mydatabase->prepare($query);
        $stmt->bind_param("ss", $fname, $lname);
        if ($stmt->execute()) {
            echo "<script>
            window.addEventListener('DOMContentLoaded', function() {
                openDialog(['Profile updated successfully!'], 'Notification');
            });
            </script>";
        } else {
            echo "<script>
            window.addEventListener('DOMContentLoaded', function() {
            openDialog(['Failed to update profile!'], 'Notification');
            });
            </script>";
        }
    }
}
?>

<form class="profile-container" action="index.php?page=edit_profile" method="post">
<?php
    $query = "SELECT * FROM account WHERE username = '" .$_SESSION['username'] ."';";
    $result = $mydatabase->query($query)->fetch_assoc();
?>
    <div class="profile-header">
        <h2>Profile Information</h2>
        <p>Role: <?= htmlspecialchars($_SESSION['role']); ?></p>
    </div>

    <div class="profile-info">
        <label>First Name:</label>
        <input type="text" name="fname" maxlength="255"
               <?php if ($_SESSION['role'] == 'admin') echo 'readonly'; ?>
        value="<?php echo htmlspecialchars($result['fname']); ?>">
    </div>

    <div class="profile-info">
        <label>Last Name:</label>
        <input type="text" name="lname" maxlength="255"
        value="<?php echo htmlspecialchars($result['lname']); ?>">
    </div>

    <button type="submit" class="save-btn">
        Save
    </button>
</form>