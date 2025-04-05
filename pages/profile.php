<?php
    $query = "SELECT * FROM account WHERE username = '" .$_SESSION['username'] ."';";
    $result = $mydatabase->query($query)->fetch_assoc();
?>

<div class="profile-container">
    <div class="profile-header">
        <h2>Profile Information</h2>
        <h4><?php echo htmlspecialchars($_SESSION['username']); ?></h4>
        <p>Role: <?= htmlspecialchars($_SESSION['role']); ?></p>
    </div>

    <div class="profile-info">
        <label>First Name:</label>
        <p><?php echo htmlspecialchars($result['fname']); ?></p>
    </div>

    <div class="profile-info">
        <label>Last Name:</label>
        <p><?php echo htmlspecialchars($result['lname']); ?></p>
    </div>

    <div class="profile-info">
        <label>Email:</label>
        <p><?php echo htmlspecialchars($result['email']); ?></p>
    </div>

    <div class="actions">
        <a href="#">Edit Profile</a>
        <a href="index.php?page=resetpssw">Change Password</a>
        <a href="#">Order History</a>
        <a class="logout" onclick="openLogoutDialog()">Logout</a>
    </div>
</div>