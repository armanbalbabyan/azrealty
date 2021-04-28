<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<title>SignUp</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="signup-form">
	<form class="signup" action="signup.php" method="post">
		<h2 class="display-inline">Sign Up</h2>
		<hr>
		<div class="form-group">
			<div class="input-group">
				<span class="input-group-addon"><i class="fa fa-user"></i></span>
				<input type="email" class="form-control" name="email" placeholder="Email" required="required">
			</div>
        </div>
		<div class="form-group">
			<div class="input-group">
				<span class="input-group-addon"><i class="fa fa-lock"></i></span>
				<input type="password" minlength="6" required="true" class="form-control" name="pass" placeholder="Password" required="required">
			</div>
        </div>
		<div class="form-group">
			<div class="input-group">
				<span class="input-group-addon">
					<i class="fa fa-lock"></i>
					<i class="fa fa-check"></i>
				</span>
				<input type="pass" minlength="6" required="true" class="form-control" name="passconf" placeholder="Confirm Password" required="required">
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

if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['signup']))
{
	$conn = new mysqli($host, $user, $password, $dbname);
	$email = $_POST['email']; 

	$query_unique = "SELECT id from `users` where `email` = '$email'";

	if (mysqli_num_rows($conn->query($query_unique))) 
	{
  		echo "<h2 style='color: red'> A user with '$email' email already exists, please try with another one </h2>";

  	}
  	else
  	{
		$pass = $_POST['pass'];
		$passconf = $_POST['passconf'];

		if ($pass == $passconf)
		{
			$hashed_pass = password_hash($pass, 1);
			if ($conn -> connect_errno)
			{
  				die("Connection Failed: " . $conn -> connect_error);
  			}
  			$query = "INSERT into users (`email`, `password`) VALUES ('$email', '$hashed_pass')";
			if ($conn->query($query) === TRUE) 
			{
				$user = mysqli_fetch_assoc ($conn->query("SELECT * from users WHERE `email` = '$email'"));
				$_SESSION["id"] = $user["ID"];
 				header("Location: allannouncements.php");
			}
 			$conn->close();
		}
		else
		{
			echo "<h2 style='color:red'> Passwords don't match </h2>";
		}

	}
}
?>



