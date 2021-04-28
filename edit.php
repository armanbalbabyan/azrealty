<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

	<form action="index.php" >
		<input type="image" src="home32.png">
	</form> <br>

</body>
</html>



<?php 

session_start();

$user_id = $_SESSION["id"]; 
$host = "localhost";
$user = "root";
$password = "";
$dbname = "realestate";

$conn = new mysqli($host, $user, $password, $dbname);


if (isset($_SESSION["id"])){
	echo "<form action='index.php' method='post'> <input type='submit' name='logout' value='Log Out'> </form>";
	$user_id = $_SESSION["id"];
}

if(isset($_POST['edit']))
{
	$announcement_id = $_POST['id'];
	$get_announcement = "SELECT * FROM `announcements` WHERE `id`='$announcement_id'";
	$query = $conn->query($get_announcement);

	if ($query)
{
	$announcements = mysqli_fetch_assoc ($query);
	
	$title = $announcements['title'];
	$price = $announcements['price'];
	$location = $announcements['location'];
	$telephone = $announcements['telephone'];
	$description = $announcements['description'];
	$image = $announcements['images'];
	$announcement_id = $announcements['id'];
	$sale_rent = $announcements['sale_rent'];

	switch ($sale_rent) {
	 	case 'rent':
	 		$rent_selected = 'checked = "true"';
	 		$sale_selected = '';
	 		echo "rent should be selected <br>";
	 		break;
	 	
	 	case 'sale':
	 		$sale_selected = 'checked = "true"';
	 		$rent_selected = '';
	 		echo "sale should be selected <br>";
	 		break;	
	 }
}}
?>

 	<div name = 'announcement'>
 		<form action="announcementsview.php" method="POST">
 			Title: <input type="text" name="title" value="<?php echo $title ?>">
 			<br>
 			For: <input type="radio" id="sale" name="sale_rent" value="sale" <?php echo $sale_selected; ?>>
 			<label for="sale">Sale</label>
  			<input type="radio" id="rent" name="sale_rent" value="rent" <?php echo $rent_selected; ?>>
 			<label for="rent">Rent</label><br>
 			Price: <input type="text" name="price" value="<?php echo $price ?>">
 			<br>
 			Location: <input type="text" name="location" value="<?php echo $location ?>">
 			<br>
 			telephone: <input type="text" name="telephone" value="<?php echo $telephone ?>">
 			<br>
 			Description: <input type="text" name="description" value="<?php echo $description ?>">
 			<br>
 			<input type="submit" name="update" value="Save Changes">
 			<input type="hidden" name="announcement_id" value="<?php echo $announcement_id ?>">		
 		</form>
 	</div>