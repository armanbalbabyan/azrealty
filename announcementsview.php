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
	</form> <br>
	
	<form method="GET">
		<input type="text" name="searchphrase" placeholder="Search">
		<input type="submit" name="search" value="Search">
	</form> <br>
	<form action="allannouncements.php">
		<input type="submit" name="all" value="View All Announcements">	
	</form>


	<br>
	<form action=announcementsadd.php>
		<input type="submit" name="add" value="Add Announcements">
	</form>
	<br>

	<form method="GET">
		<label for="sortBy">Sort By:</label> 
		
		<select name="sorting" id="sorting" onchange="this.form.submit()">
			<option value="" disabled selected> Choose option </option>
    		<option  value="ORDER BY `price` DESC"> Price &#8595;</option>
    		<option  value="ORDER BY `price` ASC"> Price &#8593;</option>
    		<option  value="ORDER BY `location` DESC">Location &#8595;</option>
    		<option  value="ORDER BY `location` ASC">Location &#8593;</option>
		</select>
	</form><br>

	<form method="GET" action="#">
		<label for="sortBy">Choose announcements only:</label> 
		
		<select name="filtering" id="filtering" onchange="this.form.submit()">
			<option value="" disabled selected> Choose option </option>
    		<option  value="WHERE `sale_rent`='sale'"> For Sale</option>
    		<option  value="WHERE `sale_rent`='rent'"> For Rent</option>
		</select>
	</form> <br>
</body>
</html>

<?php

session_start();
if (isset($_SESSION["id"])){
	echo "<form action='index.php' method='post'> <input type='submit' name='logout' value='Log Out'> </form>";

	echo "there is a signed in user ". $_SESSION["id"]."<br>";
$user_id = $_SESSION["id"]; 
}
$host = "localhost";
$user = "root";
$password = "";
$dbname = "realestate";

$conn = new mysqli($host, $user, $password, $dbname);

if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['update']))
{
	$edited_title = $_POST['title'];
	$edited_price = $_POST['price'];
	$edited_description = $_POST['description'];
	$edited_telephone = $_POST['telephone'];
	$edited_location = $_POST['location'];
	$id_toedit = $_POST['announcement_id'];
	$edited_sale_rent = $_POST['sale_rent'];
	$update_query = "UPDATE `announcements` SET `title`='$edited_title', `price`='$edited_price', `description`='$edited_description', `telephone`='$edited_telephone', `location`='$edited_location', `sale_rent`='$edited_sale_rent' WHERE `id`='$id_toedit'";
	//echo $update_query."<br>";
	if ($conn->query($update_query)) 
	{
		echo "<h1 style='color: green'> The announcement is updated </h1>";
	}
}

if(isset($_GET['search']) && $_GET['searchphrase'])
{
	$searchphrase = $_GET['searchphrase'];
	$get_announcements = "SELECT * FROM `announcements` WHERE (`user_id`='$user_id' AND `title` LIKE '%{$searchphrase}%') OR (`user_id`='$user_id' AND `location` LIKE '%{$searchphrase}%') OR (`user_id`='$user_id' AND `price` LIKE '%{$searchphrase}%') OR (`user_id`='$user_id' AND `telephone` LIKE '%{$searchphrase}%') OR (`user_id`='$user_id' AND `description` LIKE '%{$searchphrase}%') ";
}
elseif(isset($_GET['sorting']))
{
	$sorting = $_GET['sorting'];
	$get_announcements = "SELECT * FROM `announcements` WHERE `user_id`='$user_id' ".$sorting;
}
elseif (isset($_GET['filtering']))
{
	$filtering = $_GET['filtering'];
	$get_announcements = "SELECT * FROM `announcements` $filtering AND `user_id`=$user_id";
	// echo $all_announcements. "<br> filtering <br>";;
}
else
{
	$get_announcements = "SELECT * FROM `announcements` WHERE `user_id`='$user_id'";
} 

//echo $get_announcements;

$query = $conn->query($get_announcements);

$NO = 1;
	
if (!mysqli_num_rows($query))

{
	echo "<h2 style='color: blue'> There are no announcements</h2>";
}
else if ($query)
{
	while ($announcements = mysqli_fetch_assoc ($query))
	{
		$title = $announcements['title'];
		$price = $announcements['price'];
		$location = $announcements['location'];
		$telephone = $announcements['telephone'];
		$description = $announcements['description'];
		$image = $announcements['images'];
		$announcement_id = $announcements['id'];
		$sale_rent = $announcements['sale_rent'];

 	?>
 	<div name = 'announcement'>
 		<h3><?php echo $NO.". ".$title. " For: ".$sale_rent ?></h3>
 		 <form method="post" action="edit.php"> <input type="submit" name="edit" value="Edit"> <input type="hidden" name="id" value="<?php echo $announcement_id;?>"> </form>
 		<p>Price: $<?php echo $price ?></p>
 		<p>Location: <?php echo $location ?></p>
 		<p>Phone number: <?php echo $telephone ?></p>
 		<p>Description: <?php echo $description ?></p>
 		<p> <?php if ($image){ echo'<img style="width: 100px" src="uploads/'.$image.'">';} ?> </p>
 	</div>
 	<?php
 	$NO++;
	}
}

?>
