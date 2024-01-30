<?php
session_start();

// Check if the admin is not logged in, redirect to login page
if (!isset($_SESSION['admin_username'])) {
    header("Location: admin_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<div class="company-name">
        Olive Tree Restaurant
    </div>

    <nav>
        <ul>
            <li><a href="admin_logout.php">Logout</a></li>
        </ul>
    </nav>
    <br>
    <h1>Admin Dashboard</h1>
    <p>Welcome, <?= $_SESSION['admin_username'] ?>!</p>

    <h2>Menu Management</h2>
    <ul>
        <li><a href="add_menu_item.php">Add Menu Item</a></li>
        <li><a href="update_menu_item.php">Update Menu Item</a></li>
        <li><a href="delete_menu_item.php">Delete Menu Item</a></li>
    </ul>

    <h2>User Information</h2>
    <ul>
        <li><a href="view_users.php">View User Information</a></li>
    </ul>

</body>
</html>
