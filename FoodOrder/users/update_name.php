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

// Check if the update name form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_name'])) {
    $newName = $_POST['new_name'];

    // Validate the new name (you can add more validation here)
    if (empty($newName)) {
        $error = "Name is required.";
    } else {
        // Get the current username from the session
        $username = $_SESSION['username'];

        // Update the name in the database
        $updateQuery = "UPDATE users SET name = '$newName' WHERE username = '$username'";
        if (mysqli_query($conn, $updateQuery)) {
            $success = "Name updated successfully.";
        } else {
            $error = "Error updating name: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Name</title>
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
            <li><a href="order_history.php">Order History</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>
    <h1>Update Name</h1>

    <?php if (isset($error)): ?>
        <p class="error"><?= $error ?></p>
    <?php endif; ?>

    <?php if (isset($success)): ?>
        <p class="success"><?= $success ?></p>
    <?php endif; ?>

    <!-- Create a form to update the name -->
    <form method="POST" action="update_name.php">
        <label for="new_name">New Name:</label>
        <input type="text" name="new_name" id="new_name" required><br><br>

        <button type="submit" name="update_name">Update Name</button>
    </form>

    <p><a href="profile.php">Back to Profile</a></p>
</body>
</html>
