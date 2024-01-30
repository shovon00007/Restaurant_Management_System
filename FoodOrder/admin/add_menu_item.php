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

// Initialize variables to store form input
$itemName = '';
$category = '';
$price = '';
$success_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_item'])) {
    // Get form input
    $itemName = $_POST['item_name'];
    $category = $_POST['category'];
    $price = $_POST['price'];

    // Validate form input (you can add more validation as needed)
    if (empty($itemName) || empty($category) || empty($price)) {
        $error_message = "Please fill in all fields.";
    } else {
        // Insert the new menu item into the 'food_items' table
        $insertQuery = "INSERT INTO food_items (food_name, category, price) VALUES ('$itemName', '$category', $price)";
        if (mysqli_query($conn, $insertQuery)) {
            $success_message = "Menu item added successfully!";
            // Clear form input fields
            $itemName = $category = $price = '';
        } else {
            $error_message = "Error adding menu item: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Menu Item</title>
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
    </nav>
    <br>
    <h1>Add Menu Item</h1>
    
    <?php if (!empty($error_message)): ?>
        <p style="color: red;"><?= $error_message ?></p>
    <?php elseif (!empty($success_message)): ?>
        <p style="color: green;"><?= $success_message ?></p>
    <?php endif; ?>

    <form method="POST" action="add_menu_item.php">
        <label for="item_name">Item Name:</label>
        <input type="text" name="item_name" id="item_name" value="<?= $itemName ?>" required><br><br>

        <label for="category">Category:</label>
        <select name="category" id="category" required>
            <option value="breakfast">Breakfast</option>
            <option value="lunch">Lunch</option>
            <option value="dinner">Dinner</option>
            <option value="drinks">Drinks</option>
        </select><br><br>

        <label for="price">Price:</label>
        <input type="text" name="price" id="price" value="<?= $price ?>" required><br><br>

        <button type="submit" name="add_item">Add Item</button>
    </form>

</body>
</html>
