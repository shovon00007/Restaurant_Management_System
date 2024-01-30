<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="company-name">
        Olive Tree Restaurant
    </div>

    <nav>
        <ul>
            <li><a href="menu.php">Menu</a></li>
            <li><a href="about.php">About</a></li>
            <li><a href="Profile.php">Profile</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>
    <h1>Order Confirmation</h1>

    <p>Your order has been successfully placed!</p>

    <p><a href="menu.php">Back to Menu</a></p>
    <p><a href="order_history.php">View Order History</a></p>
</body>
</html>
