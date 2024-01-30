<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Database connection code
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

// Function to fetch menu items (you should adapt this to your database structure)
function fetchMenuItems($category) {
    global $conn;
    // Query to fetch menu items based on category
    $query = "SELECT * FROM food_items WHERE category = '$category'";
    $result = mysqli_query($conn, $query);

    $menuItems = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $menuItems[] = $row;
    }

    return $menuItems;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['place_order'])) {
    // Process order placement
    $username = $_SESSION['username'];
    $orderItems = $_POST['order_items']; // An array containing selected items and quantities

    // Loop through selected items and insert them into the 'order_info' table
    foreach ($orderItems as $itemId => $quantity) {
        $itemId = (int)$itemId;
        $quantity = (int)$quantity;

        if ($itemId > 0 && $quantity > 0) {
            // Fetch item details (you should adapt this to your database structure)
            $query = "SELECT food_name, price FROM food_items WHERE food_id = $itemId";
            $result = mysqli_query($conn, $query);
            $item = mysqli_fetch_assoc($result);

            if ($item) {
                $foodName = $item['food_name'];
                $price = $item['price'];
                $orderDate = date('Y-m-d H:i:s'); // Current date and time

                // Insert order details into the 'order_info' table
                $insertQuery = "INSERT INTO order_info (username, food_id, food_name, quantity, order_date)
                                VALUES ('$username', $itemId, '$foodName', $quantity, '$orderDate')";
                mysqli_query($conn, $insertQuery);
            }
        }
    }

    // Redirect to order confirmation page
    header("Location: order_confirmation.php");
    exit();
}

// Fetch menu items for different categories (you should adapt this to your database structure)
$breakfastItems = fetchMenuItems('breakfast');
$lunchItems = fetchMenuItems('lunch');
$dinnerItems = fetchMenuItems('dinner');
$drinksItems = fetchMenuItems('drinks');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<div class="company-name">
        Olive Tree Restaurant
    </div>

    <nav>
        <ul>
            <li><a href="about.php">About</a></li>
            <li><a href="order_history.php">Order History</a></li>
            <li><a href="Profile.php">Profile</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>
    <h1>Menu</h1>
    <form method="POST" action="menu.php">
        <!-- Display breakfast items -->
        <h2>Breakfast</h2>
        <?php foreach ($breakfastItems as $item): ?>
            <label>
                <input type="number" name="order_items[<?= $item['food_id'] ?>]" min="0"  class="quantity-input">
                <?= $item['food_name'] ?> - $<?= $item['price'] ?>
            </label><br>
        <?php endforeach; ?>

        <!-- Display lunch items -->
        <h2>Lunch</h2>
        <?php foreach ($lunchItems as $item): ?>
            <label>
                <input type="number" name="order_items[<?= $item['food_id'] ?>]" min="0"  class="quantity-input">
                <?= $item['food_name'] ?> - $<?= $item['price'] ?>
            </label><br>
        <?php endforeach; ?>

        <!-- Display dinner items -->
        <h2>Dinner</h2>
        <?php foreach ($dinnerItems as $item): ?>
            <label>
                <input type="number" name="order_items[<?= $item['food_id'] ?>]" min="0"  class="quantity-input">
                <?= $item['food_name'] ?> - $<?= $item['price'] ?>
            </label><br>
        <?php endforeach; ?>

        <!-- Display drinks items -->
        <h2>Drinks</h2>
        <?php foreach ($drinksItems as $item): ?>
            <label>
                <input type="number" name="order_items[<?= $item['food_id'] ?>]" min="0"  class="quantity-input">
                <?= $item['food_name'] ?> - $<?= $item['price'] ?>
            </label><br>
        <?php endforeach; ?>

        <button type="submit" name="place_order">Place Order</button>
    </form>
</body>
</html>
