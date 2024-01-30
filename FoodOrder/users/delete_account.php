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

// Get the current username from the session
$username = $_SESSION['username'];

// Check if the user confirms account deletion
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_confirmation'])) {
    // Delete user account
    $deleteUserQuery = "DELETE FROM users WHERE username = '$username'";
    if (mysqli_query($conn, $deleteUserQuery)) {
        // Logout the user and redirect to the main page
        session_destroy();
        header("Location: ../index.php");
        exit();
    } else {
        $error = "Error deleting account: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Account</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <h1>Delete Account</h1>

    <?php if (isset($error)): ?>
        <p class="error"><?= $error ?></p>
    <?php endif; ?>

    <p>Are you sure you want to delete your account?</p>
    <form method="POST" action="delete_account.php">
        <button type="submit" name="delete_confirmation">Yes, Delete My Account</button>
    </form>

    <p><a href="profile.php">Cancel and Go Back</a></p>
</body>
</html>
