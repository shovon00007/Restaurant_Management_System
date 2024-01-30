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

// Initialize variables to store item selection and success/error messages
$selectedItemId = '';
$success_message = '';

// Fetch existing menu items to populate the dropdown select element
$query = "SELECT food_id, food_name FROM food_items";
$result = mysqli_query($conn, $query);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_item'])) {
    // Get selected item ID
    $selectedItemId = $_POST['selected_item'];

    // Check if the selected item ID is not empty
    if (!empty($selectedItemId)) {
        // Delete the selected menu item from the 'food_items' table
        $deleteQuery = "DELETE FROM food_items WHERE food_id = $selectedItemId";
        if (mysqli_query($conn, $deleteQuery)) {
            $success_message = "Menu item deleted successfully!";
            // Clear the selection
            $selectedItemId = '';
        } else {
            $error_message = "Error deleting menu item: " . mysqli_error($conn);
        }
    } else {
        $error_message = "Please select an item to delete.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Menu Item</title>
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
    <h1>Delete Menu Item</h1>

    <?php if (!empty($error_message)): ?>
        <p style="color: red;"><?= $error_message ?></p>
    <?php elseif (!empty($success_message)): ?>
        <p style="color: green;"><?= $success_message ?></p>
    <?php endif; ?>

    <form method="POST" action="delete_menu_item.php">
        <label for="selected_item">Select an Item to Delete:</label>
        <select name="selected_item" id="selected_item" required>
            <option value="">Select an Item</option>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <option value="<?= $row['food_id'] ?>" <?= ($row['food_id'] == $selectedItemId) ? 'selected' : '' ?>>
                    <?= $row['food_name'] ?>
                </option>
            <?php endwhile; ?>
        </select><br><br>

        <button type="submit" name="delete_item">Delete Item</button>
    </form>

</body>
</html>
