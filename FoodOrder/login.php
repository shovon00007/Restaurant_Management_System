<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="company-name">
        Olive Tree Restaurant
    </div>

    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="about.php">About</a></li>
            <li><a href="signup.php">SignUp</a></li>
            <li><a href="login.php">Login</a></li>
        </ul>
    </nav>
    <?php
    // Display any login errors
    if (isset($error)) {
        echo '<div class="error">' . $error . '</div>';
    }
    ?>

    <div class="login-container">
        <h2>Login</h2>
        <form method="POST" action="login.php">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" placeholder="Username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" placeholder="Password" required>
            </div>
            <div class="row">
                <button type="submit">Log In</button>
            </div>
        </form>
        <br>
            <a class="signup-link" href="signup.php">Don't have an account? Sign up</a>
    </div>
</body>
</html>
<?php
include("db.php");
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	$username=$_POST['username'];
	$pass=$_POST['password'];

	$sql="select username,password from users where username='$username' and password='$pass'";
            $cs=mysqli_query($conn,$sql);

            if(mysqli_num_rows($cs)==1)
            {
                $_SESSION['username'] = $username;
                $_SESSION['customer_login_status']="loged in";
                header("Location:users/menu.php");
            }
            else
            {
                $error = "Incorrect username or password. Please try again.";
            }
	
}
?>
