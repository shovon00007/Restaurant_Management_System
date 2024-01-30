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

// Fetch the user's current email from the database
$currentEmailQuery = "SELECT email FROM users WHERE username = '$username'";
$currentEmailResult = mysqli_query($conn, $currentEmailQuery);

if (!$currentEmailResult) {
    die("Error fetching current email: " . mysqli_error($conn));
}

$row = mysqli_fetch_assoc($currentEmailResult);
$currentEmail = $row['email'];

// Check if the update email form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_email'])) {
    $newEmail = $_POST['new_email'];

    // Validate the new email (you can add more validation here)
    if (empty($newEmail) || !filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } elseif ($newEmail === $currentEmail) {
        $error = "New email cannot be the same as the current email.";
    } else {
        // Check if the new email already exists in the database
        $checkEmailQuery = "SELECT * FROM users WHERE email = '$newEmail'";
        $checkResult = mysqli_query($conn, $checkEmailQuery);

        if (mysqli_num_rows($checkResult) > 0) {
            $error = "Email address already in use.";
        } else {
            // Update the email in the database
            $updateQuery = "UPDATE users SET email = '$newEmail' WHERE username = '$username'";
            if (mysqli_query($conn, $updateQuery)) {
                $success = "Email updated successfully.";
            } else {
                $error = "Error updating email: " . mysqli_error($conn);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Email</title>
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
    <h1>Update Email</h1>

    <?php if (isset($error)): ?>
        <p class="error"><?= $error ?></p>
    <?php endif; ?>

    <?php if (isset($success)): ?>
        <p class="success"><?= $success ?></p>
    <?php endif; ?>

    <!-- Create a form to update the email -->
    <form method="POST" action="update_email.php">
        <label for="new_email">New Email:</label>
        <input type="email" name="new_email" id="new_email" required><br><br>

        <button type="submit" name="update_email">Update Email</button>
    </form>

    <p><a href="profile.php">Back to Profile</a></p>
</body>
</html>
