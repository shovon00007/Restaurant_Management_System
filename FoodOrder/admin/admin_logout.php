<?php
session_start();

// Unset all admin session variables
unset($_SESSION['admin_username']);

// Destroy the admin session
session_destroy();

// Redirect to the main folder directory (adjust the path as needed)
header("Location: ../index.php");
exit();
?>
