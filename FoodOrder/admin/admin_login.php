<?php
session_start();

// Check if the admin is already logged in
if (isset($_SESSION['admin_username'])) {
    header("Location: admin_dashboard.php"); // Redirect to the admin dashboard
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Database connection code
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "restaurant"; // Replace with your actual database name

    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Handle admin login form submission
    $admin_username = $_POST['admin_username'];
    $admin_password = $_POST['admin_password'];

    // Fetch admin record from the database
    $query = "SELECT username, password FROM admins WHERE username = '$admin_username'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        $stored_password = $row['password'];

        // Verify the entered password against the stored password (plain text comparison)
        if ($admin_password === $stored_password) {
            // Admin login successful
            $_SESSION['admin_username'] = $admin_username;
            header("Location: admin_dashboard.php"); // Redirect to the admin dashboard
            exit();
        } else {
            $login_error = "Invalid admin credentials"; // Display an error message
        }
    } else {
        $login_error = "Admin not found"; // Display an error message
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <h1>Admin Login</h1>
    <?php if (isset($login_error)): ?>
        <p><?= $login_error ?></p>
    <?php endif; ?>
    <form method="POST" action="admin_login.php">
        <label for="admin_username">Username:</label>
        <input type="text" name="admin_username" id="admin_username" required><br><br>

        <label for="admin_password">Password:</label>
        <input type="password" name="admin_password" id="admin_password" required><br><br>

        <button type="submit">Login</button>
    </form>
</body>
</html>
