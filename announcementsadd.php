<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<title>SignIn</title>
	<link rel="icon" href="home.png" type="image/gif" sizes="16x16">
</head>
<body>

	<form action="index.php" >
		<input type="image" src="home32.png">
	</form>
	<br>
	<form class="announcements" action="announcementsadd.php" method="post" enctype="multipart/form-data">

		For<label style="color: red">*</label>:		
  		<input type="radio" id="sale" name="sale_rent" value="sale">
 		<label for="sale">Sale</label>
  		<input type="radio" id="rent" name="sale_rent" value="rent">
 		<label for="rent">Rent</label><br>
		Title<label style="color: red">*</label>: 
		<input type="text" name="title" placeholder="Title" required="true"> <br>
		<br>
		Location<label style="color: red">*</label>: 
		<input type="text" name="location" placeholder="Location" required="true"> <br>
		<br>
		Price $<label style="color: red">*</label>: 
		<input type="number" name="price" placeholder="Price" required="true"> <br>
		<br>		Telephone<label style="color: red">*</label>: 
		<input type="tel" name="Telephone" placeholder="Telephone"  oninvalid="this.setCustomValidity('Please enter your Phone number')" required="true"> <br>		
		<br>
		Description<label style="color: red">*</label>: 
		<input type="text" name="Description" placeholder="Description" required="true"> <br>
		<br>
		<input type="file" name="image"> <br>
		<br>
		<input type="submit" name="add" value="Add announcement" >
		
	</form>


<?php
session_start();

$host = "localhost";
$user = "root";
$password = "";
$dbname = "realestate";

if (isset($_SESSION["id"]))
{
	if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['add']))
	{
	

		$conn = new mysqli($host, $user, $password, $dbname);

		$user_id = $_SESSION["id"];	
		$title = str_replace("'", "''", $_POST["title"]);
		$telephone = $_POST["Telephone"];
		$description = str_replace("'", "''", $_POST["Description"]);
		$location = str_replace("'", "''", $_POST["location"]);
		$price = $_POST["price"];
		$sale_rent = $_POST["sale_rent"];

		$filename = $_FILES['image']['name'];
	    $destination = 'uploads/' . $filename;$extension = pathinfo($filename, PATHINFO_EXTENSION);
   		$file = $_FILES['image']['tmp_name'];
    	$size = $_FILES['image']['size'];


    	$add_announcement="INSERT INTO `announcements` (user_id, title, telephone, description, location, price, images, sale_rent) VALUES ('$user_id', '$title', '$telephone', '$description', '$location', '$price', '$filename', '$sale_rent')";
    	//echo $add_announcement;

    	if ($size > 1000000)
    	{
        	echo "File too large!";
    	} 
    	else
    	{
    		if ($file)
    		{
    			if (move_uploaded_file($file, $destination) && $conn->query($add_announcement))
    			{
    				echo "<h2 style='color: green'>The announcement added</h2>";
    			}
    			else
    			{
    				echo $conn -> error."<br/>";
    				//echo $add_announcement;
    			}
    		}
    		elseif ($conn->query($add_announcement))
    		{
    			echo "<h2 style='color: green'>The announcement added</h2>";
    		}
    			else
    		{
    			echo $conn -> error."<br/>";
    			//echo $add_announcement;
    		}

		}
	}
}
?>

<br> <br>
<form action=announcementsview.php>
		<input type="submit" name="view" value="View My Announcements">
</form>
<br>
	<form action="allannouncements.php">
		<input type="submit" name="all" value="View All Announcements">	
	</form>
</body>
</html>