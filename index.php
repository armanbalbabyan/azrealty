<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>A-Z Real Estate</title>
	<link rel="stylesheet" href="main.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
	<div class="carousel fade-carousel slide carousel-fade" data-ride="carousel"
data-interval="5000" id="bs-carousel">
    <!-- Overlay -->
    <!-- Indicators -->
    <ol class="carousel-indicators">
        <li data-target="#bs-carousel" data-slide-to="0" class="active"></li>
        <li data-target="#bs-carousel" data-slide-to="1"></li>
        <li data-target="#bs-carousel" data-slide-to="2"></li>
    </ol>
    <!-- Wrapper for slides -->
    <div class="carousel-inner">
        <div class="item slides active carousel-item">
            <div class="slide-1">
                <div class="overlay"></div>
            </div>
        </div>
        <div class="item slides carousel-item">
            <div class="slide-2">
                <div class="overlay"></div>
            </div>
        </div>
        <div class="item slides carousel-item">
            <div class="slide-3">
                <div class="overlay"></div>
            </div>
        </div>
        <div class="hero">
            <hgroup>
                 <h1>Welcome to A-Z real estate agency</h1> 
                 <h3>We will help you find your new home</h3>
            </hgroup>
			<form action="allannouncements.php">
				<button 
					class="btn btn-hero btn-lg" 
					role="button" 
					type="submit">
					See all announceents</button>
			</form>
			<form action="signin.php">
				<button
					class="btn btn-regular btn-md"
					role="button"
					type="submit"
				>Sign in</button>
			</form>
			<form action="signup.php">
				<button
					class="btn btn-regular btn-md"
					role="button"
					type="submit"
				>Sign up</button>
			</form>
        </div>
    </div>
</div>
</body>
</html>

<?php
session_start();

if (isset($_SESSION["id"]))
{
	echo "<form action='index.php' method='post'> <input type='submit' name='logout' value='&#xe163;' class='glyphicon'> </form>";
	echo "<form action='announcementsadd.php' method='post'> <input type='submit' name='addannouncements' value='Add Announcements'> </form>";
	echo "you are logged in".$_SESSION["id"]."<br>";
	echo "<form action=announcementsview.php><input type='submit' name='view' value='View My Announcements'></form>";	
}

if (isset($_POST['logout']))
{
	unset($_SESSION["id"]);
 	header("Location: index.php");
}

?>