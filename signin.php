<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<title>SignIn</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="signup-form">
		<form class="signin" action="signin.php" method="post">
			<h2>Sign in</h2>
			<hr>
			<div class="form-group">
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-user"></i></span>
					<input type="email" class="form-control" name="email" placeholder="Enter Your Email" required="true">
				</div>
			</div>
			<div class="form-group">
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-lock"></i></span>
					<input type="password" class="form-control" name="pass" placeholder="Enter Your Password" minlength="6" required="true">
				</div>
			</div>
			<div class="form-group">
            	<button type="submit" class="btn btn-primary btn-lg">Sign Up</button>
        	</div>
		</form>
	</div>

</body>
</html>

<?php
session_start();
if (isset($_SESSION["id"]))
{
	header("Location: allannouncements.php");	
}
$host = "localhost";
$user = "root";
$password = "";
$dbname = "realestate";

if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['signin']))
{
	$email = $_POST['email'];
	$pass = $_POST['pass'];

	$conn = new mysqli($host, $user, $password, $dbname);
	if ($conn->connect_errno)
	{
  		die("Connection Failed: " . $conn->connect_error);
  	}

  	$get_user = "SELECT * from users WHERE `email`='$email'";
  	
  	$user = mysqli_fetch_assoc ($conn->query($get_user));
		
	 if (password_verify($pass,$user['password']))
	 {

     	$_SESSION["id"] = strval($user['ID']);
 		header("Location: allannouncements.php");
	} 
	else 
	{
    	echo "<h2 style='color: red'>Invalid credentials</h2>";
	}	

	

 	$conn->close();

}

?>

