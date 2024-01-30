<?php
session_start();

// Check if the admin is not logged in, redirect to login page
if (!isset($_SESSION['admin_username'])) {
    header("Location: admin_login.php");
    exit();
}

// Database connection code (similar to what you have in admin_login.php)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "restaurant";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Initialize variables to store form input and item selection
$selectedItemId = '';
$newItemName = '';
$newPrice = '';
$success_message = '';

// Fetch existing menu items to populate the dropdown select element
$query = "SELECT food_id, food_name FROM food_items";
$result = mysqli_query($conn, $query);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_item'])) {
    // Get form input
    $selectedItemId = $_POST['selected_item'];
    $newItemName = $_POST['new_item_name'];
    $newPrice = $_POST['new_price'];

    // Validate form input (you can add more validation as needed)
    if (empty($selectedItemId) || empty($newItemName) || empty($newPrice)) {
        $error_message = "Please fill in all fields.";
    } else {
        // Update the selected menu item in the 'food_items' table
        $updateQuery = "UPDATE food_items SET food_name = '$newItemName', price = '$newPrice' WHERE food_id = $selectedItemId";
        if (mysqli_query($conn, $updateQuery)) {
            $success_message = "Menu item updated successfully!";
            // Clear form input fields
            $selectedItemId = $newItemName = $newPrice = '';
        } else {
            $error_message = "Error updating menu item: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Menu Item</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<div class="company-name">
        Olive Tree Restaurant
    </div>

    <nav>
        <ul>
            <li><a href="admin_dashboard.php">Dashboard</a></li>
            <li><a href="admin_logout.php">Logout</a></li>
        </ul>
    </nav><br>
    <h1>Update Menu Item</h1>

    <?php if (!empty($error_message)): ?>
        <p style="color: red;"><?= $error_message ?></p>
    <?php elseif (!empty($success_message)): ?>
        <p style="color: green;"><?= $success_message ?></p>
    <?php endif; ?>

    <form method="POST" action="update_menu_item.php">
        <label for="selected_item">Select an Item to Update:</label>
        <select name="selected_item" id="selected_item" required>
            <option value="">Select an Item</option>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <option value="<?= $row['food_id'] ?>" <?= ($row['food_id'] == $selectedItemId) ? 'selected' : '' ?>>
                    <?= $row['food_name'] ?>
                </option>
            <?php endwhile; ?>
        </select><br><br>

        <label for="new_item_name">New Item Name:</label>
        <input type="text" name="new_item_name" id="new_item_name" value="<?= $newItemName ?>" required><br><br>

        <label for="new_price">New Price:</label>
        <input type="text" name="new_price" id="new_price" value="<?= $newPrice ?>" required><br><br>

        <button type="submit" name="update_item">Update Item</button>
    </form>

</body>
</html>
