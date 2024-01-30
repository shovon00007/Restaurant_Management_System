<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Database connection code goes here
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

// Fetch the user's order history from the 'order_info' table
$username = $_SESSION['username'];
$query = "SELECT * FROM order_info WHERE username = '$username' ORDER BY order_date";
$result = mysqli_query($conn, $query);

$ordersByDate = array();

while ($row = mysqli_fetch_assoc($result)) {
    $orderDate = $row['order_date'];

    // Group orders by date
    if (!isset($ordersByDate[$orderDate])) {
        $ordersByDate[$orderDate] = array();
    }

    $ordersByDate[$orderDate][] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History</title>
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

    <h1>Order History</h1>

    <?php if (empty($ordersByDate)): ?>
        <p>No orders found.</p>
    <?php else: ?>
        <?php $orderCount = 1; ?>
        <?php foreach ($ordersByDate as $orderDate => $orders): ?>
            <p><?= ordinal($orderCount) ?> Order Placed</p>
            <p>Order Time: <?= $orderDate ?></p>
            <?php foreach ($orders as $order): ?>
                <ul>
                    <li>Food Name: <?= $order['food_name'] ?></li>
                    <li>Quantity: <?= $order['quantity'] ?></li>
                </ul>
            <?php endforeach; ?>
            <?php $orderCount++; ?>
        <?php endforeach; ?>
    <?php endif; ?>

    <p><a href="menu.php">Back to Menu</a></p>
</body>
</html>

<?php
// Function to convert numbers to ordinal numbers (1st, 2nd, 3rd, etc.)
function ordinal($number) {
    $ends = array('th', 'st', 'nd', 'rd', 'th', 'th', 'th', 'th', 'th', 'th');
    if ((($number % 100) >= 11) && (($number % 100) <= 13)) {
        return $number . 'th';
    } else {
        return $number . $ends[$number % 10];
    }
}
?>
