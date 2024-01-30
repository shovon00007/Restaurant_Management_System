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

// Initialize variables to store user information
$userInfo = array();
$selectedUser = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['select_user'])) {
    $selectedUser = $_POST['selected_user'];

    // Retrieve user information based on the selected username
    $query = "SELECT * FROM users WHERE username = '$selectedUser'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) == 1) {
        $userInfo = mysqli_fetch_assoc($result);
    } else {
        // Handle error if the selected user is not found
        $error_message = "User not found.";
    }
}

// Fetch all registered usernames from the 'users' table (after retrieving user info)
$query = "SELECT username FROM users";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View User Information</title>
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
    <h1>View User Information</h1>
    <form method="POST" action="view_users.php">
        <label for="selected_user">Select a User:</label>
        <select name="selected_user" id="selected_user">
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <option value="<?= $row['username'] ?>" <?= ($row['username'] === $selectedUser) ? 'selected' : '' ?>>
                    <?= $row['username'] ?>
                </option>
            <?php endwhile; ?>
        </select>
        <button type="submit" name="select_user">View User Info</button>
    </form>

    <?php if (!empty($userInfo)): ?>
        <h2>User Information for <?= $selectedUser ?></h2>
        <ul>
            <li>Profile Picture: <br><img src="../Cimage/<?= $userInfo['pic'] ?>" alt="Profile Picture" width="250"></li>
            <li>Name: <?= $userInfo['name'] ?></li>
            <li>Email: <?= $userInfo['email'] ?></li>
            <li>Gender: <?= $userInfo['gender'] ?></li>
            <li>Birthdate: <?= $userInfo['birthdate'] ?></li>
        </ul>
    <?php elseif (isset($error_message)): ?>
        <p><?= $error_message ?></p>
    <?php endif; ?>

</body>
</html>