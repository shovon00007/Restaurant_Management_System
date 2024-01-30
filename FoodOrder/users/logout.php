<?php
// Start the session
session_start();

// Unset all session variables
session_unset();

// Destroy the session
session_destroy();

// Redirect to the main folder's index.php page
header("Location: ../index.php");
exit();
?>
