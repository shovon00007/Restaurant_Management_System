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

// Check if the update profile picture form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_profile_pic'])) {
    $newProfilePic = $_FILES['new_profile_pic'];

    // Check if a new profile picture is uploaded
    if ($newProfilePic['error'] === UPLOAD_ERR_OK) {
        $uploadDir = "../Cimage/"; // Directory where profile pictures are stored (adjust the path as needed)
        $tempName = $newProfilePic['tmp_name'];
        $extension = pathinfo($newProfilePic['name'], PATHINFO_EXTENSION);
        $newFileName = $username . "_profile." . $extension;
        $destination = $uploadDir . $newFileName;

        // Move the uploaded file to the destination directory
        if (move_uploaded_file($tempName, $destination)) {
            // Update the profile picture filename in the database
            $updatePicQuery = "UPDATE users SET pic = '$newFileName' WHERE username = '$username'";
            if (mysqli_query($conn, $updatePicQuery)) {
                $success = "Profile picture updated successfully.";
            } else {
                $error = "Error updating profile picture: " . mysqli_error($conn);
            }
        } else {
            $error = "Error uploading profile picture.";
        }
    } else {
        $error = "No file uploaded or an error occurred.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile Picture</title>
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
    <h1>Update Profile Picture</h1>

    <?php if (isset($error)): ?>
        <p class="error"><?= $error ?></p>
    <?php endif; ?>

    <?php if (isset($success)): ?>
        <p class="success"><?= $success ?></p>
    <?php endif; ?>

    <!-- Create a form to update the profile picture -->
    <form method="POST" action="update_profile_pic.php" enctype="multipart/form-data">
        <label for="new_profile_pic">Upload New Profile Picture:</label>
        <input type="file" name="new_profile_pic" id="new_profile_pic" accept="image/*" required><br><br>

        <button type="submit" name="update_profile_pic">Update Profile Picture</button>
    </form>

    <p><a href="profile.php">Back to Profile</a></p>
</body>
</html>
