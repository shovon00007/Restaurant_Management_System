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

// Fetch user data from the database
$username = $_SESSION['username'];
$query = "SELECT * FROM users WHERE username = '$username'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 1) {
    $user = mysqli_fetch_assoc($result);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
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
    <h1>Profile</h1>

    <!-- Display profile picture -->
    <img src="../Cimage/<?= $user['pic'] ?>" alt="Profile Picture" width="150">
    <!-- Display user information -->

    <p>Name: <?= $user['name'] ?></p>
    <p>Email: <?= $user['email'] ?></p>
    <p>Gender: <?= $user['gender'] ?></p>
    <p>Date of Birth: <?= $user['birthdate'] ?></p>

    <!-- Links to update options -->
    <br><h2>Update Options</h2>
    <ul>
        <li><a href="update_name.php">Update Name</a></li>
        <li><a href="update_email.php">Update Email</a></li>
        <li><a href="update_password.php">Update Password</a></li>
        <li><a href="update_profile_pic.php">Update Profile Picture</a></li>
    </ul>

    <!-- Delete account option -->
    <h2>Delete Account</h2>
    <form method="POST" action="delete_account.php">
        <p>Are you sure you want to delete your account? This action cannot be undone.</p>
        <button type="submit" name="delete_account">Delete Account</button>
    </form>

    <p><a href="menu.php">Back to Menu</a></p>
</body>
</html>
