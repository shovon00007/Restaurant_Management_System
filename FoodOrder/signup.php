<!DOCTYPE html>
<html>
<head>
    <title>Signup</title>
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
            <li><a href="admin/admin_login.php" style="float:left">Admin</a></li>
        </ul>
    </nav>

    <div class="signup-container">
        <h2>Sign Up</h2>
        <form action="signup.php" method="post" enctype="multipart/form-data">
			<div class="form-group">
				<label for="usename">Username:</label>
				<input type="text" id="usename" name="usename" placeholder="Username" required >
			</div>
            <div class="form-group">
                <label for="username">Name:</label>
                <input type="text" id="name" name="name" placeholder="Name" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="Email Address" required>
            </div>
            <div class="form-group">
                <label for="gender">Gender:</label>
                <label class="radio-label"><input type="radio" name="gender" value="male">Male</label>
                <label class="radio-label"><input type="radio" name="gender" value="female">Female</label>
                <label class="radio-label"><input type="radio" name="gender" value="other">Other</label>
            </div>
            <div class="form-group">
                <label for="birthdate">Birth Date:</label>
                <input type="date" id="birthdate" name="birthdate" required>
            </div>
            <div class="form-group">
                <label for="image">Profile Picture:</label>
                <input type="file" id="image" name="image">
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" placeholder="Password" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm Password:</label>
                <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm Password" required><br>
            </div>
            <div class="row">
                <button type="submit">Sign Up</button>
            </div>
                
        </form>
        <br>
        <p>Already have an account? <a href="login.php">Log in here</a></p>
    </div>
</body>
</html>
<?php
include('db.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $username=$_POST['usename'];	
    $name=$_POST['name'];
	$email=$_POST['email'];
	$gender=$_POST['gender'];
	$birthdate=$_POST['birthdate'];
    $password=$_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    $errors = array();

    if ($password !== $confirmPassword) {
        $errors[] = "Passwords do not match.";
    }

    $checkQuery = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($result) > 0) {
        $errors[] = "Username already exists. Please choose another one.";
    }
	
	//image upload code
	$ext= explode(".",$_FILES['image']['name']);
    $c=count($ext);
    $ext=$ext[$c-1];
    $date=date("D:M:Y");
    $time=date("h:i:s");
    $image_name=md5($date.$time.$username);
    $image=$image_name.".".$ext;
	 
	
	
	$query="insert into users values('$username','$name','$email','$gender','$birthdate','$image','$password')";
	if(mysqli_query($conn,$query))
	{
		echo "Successfully inserted!";
		if($image !=null){
	                move_uploaded_file($_FILES['image']['tmp_name'],"Cimage/$image");
                    }
        header("Location: login.php");
        exit(); 
    }
	else
	{
		$errors[] = "Registration failed. Please try again later.";
	}
}
?>