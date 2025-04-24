<?php
unset($_SESSION['username']);
unset($_SESSION['role']);
session_destroy();

$base_url = "http://" . $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['SCRIPT_NAME']), '/') . "/";
echo "<script>window.location.href = '" . $base_url . "home';</script>";
exit;
?>