<?php
$mydatabase->query("DELETE FROM account WHERE username = '" .$_SESSION['username'] ."';");
if ($mydatabase->affected_rows > 0) {
    echo "<script>
    alert('Account deleted successfully!');</script>";
    include("logout.php");
} else {
    echo "<script>
    document.addEventListener('DOMContentLoaded', function() {
        openDialog(['Failed to delete your account!', 'Please try again.']);
    });
    </script>";
}
?>