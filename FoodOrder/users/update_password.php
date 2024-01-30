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

// Check if the update password form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_password'])) {
    $currentPassword = $_POST['current_password'];
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    // Fetch the user's current password from the database
    $currentPasswordQuery = "SELECT password FROM users WHERE username = '$username'";
    $currentPasswordResult = mysqli_query($conn, $currentPasswordQuery);

    if (!$currentPasswordResult) {
        die("Error fetching current password: " . mysqli_error($conn));
    }

    $row = mysqli_fetch_assoc($currentPasswordResult);
    $storedPassword = $row['password'];

    // Verify the entered current password against the stored password
    if ($currentPassword === $storedPassword) {
        // Validate the new password (you can add more validation here)
        if (empty($newPassword)) {
            $error = "New password is required.";
        } elseif (strlen($newPassword) < 6) {
            $error = "New password must be at least 6 characters.";
        } elseif ($newPassword !== $confirmPassword) {
            $error = "New password and confirm password do not match.";
        } else {
            // Update the password in the database
            $updatePasswordQuery = "UPDATE users SET password = '$newPassword' WHERE username = '$username'";
            if (mysqli_query($conn, $updatePasswordQuery)) {
                $success = "Password updated successfully.";
            } else {
                $error = "Error updating password: " . mysqli_error($conn);
            }
        }
    } else {
        $error = "Current password is incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Password</title>
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
    <h1>Update Password</h1>

    <?php if (isset($error)): ?>
        <p class="error"><?= $error ?></p>
    <?php endif; ?>

    <?php if (isset($success)): ?>
        <p class="success"><?= $success ?></p>
    <?php endif; ?>

    <!-- Create a form to update the password -->
    <form method="POST" action="update_password.php">
        <label for="current_password">Current Password:</label>
        <input type="password" name="current_password" id="current_password" required><br><br>

        <label for="new_password">New Password:</label>
        <input type="password" name="new_password" id="new_password" required><br><br>

        <label for="confirm_password">Confirm New Password:</label>
        <input type="password" name="confirm_password" id="confirm_password" required><br><br>

        <button type="submit" name="update_password">Update Password</button>
    </form>

    <p><a href="profile.php">Back to Profile</a></p>
</body>
</html>
