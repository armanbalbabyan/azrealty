<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="announcementStyles.css" >
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<title>A-Z Real Estate</title>
</head>
<body>
<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
		<div class="container">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#">A-Z Realty</a>
			</div>

			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Sort by <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><button class="btn btn-link" onclick="()=>this.form.submit('ORDER BY `price` DESC')">Price &#8595;</button></li>
							<li><button class="btn btn-link" onclick="()=>this.form.submit('ORDER BY `price` ASC')"> Price &#8593;</button></li>
							<li><button class="btn btn-link" onclick="()=>this.form.submit('ORDER BY `location` DESC')">Location &#8595;</button></li>
							<li><button class="btn btn-link" onclick="()=>this.form.submit('ORDER BY `location` DESC')">Location &#8593;</button></li>
						</ul>
					</li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Filter by type <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><button class="btn btn-link" onclick="()=>this.form.submit('WHERE `sale_rent`=\'sale\'')">For sale </button></li>
							<li><button class="btn btn-link" onclick="()=>this.form.submit('WHERE `sale_rent`=\'rent\'')"> For rent</button></li>
						</ul>
					</li>
				</ul>
				
				<ul class="nav navbar-nav navbar-right">
					<li>
					<?php
						session_start();

						if (isset($_SESSION["id"])){
							?>
								
								<ul class="nav navbar-nav ml-auto">
									<li class="nav-item">
										<a class="nav-link" href="index.php"><span class="fas fa-user"></span> Logout</a>
									</li>
								</ul>
								
							<?php
							echo "";
						}

						else
						{
							?>
								
								<ul class="nav navbar-nav ml-auto">
									<a class="nav-link" href="index.php"><span class="fas fa-sign-in-alt"></span> Login</a>
								</ul>
								
							<?php
						}
					?>
					</li>

				</ul>
			</div><!-- /.navbar-collapse -->
		</div><!-- /.container-fluid -->
	</nav>

<div class="container main">

<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "realestate";

$conn = new mysqli($host, $user, $password, $dbname);

if(isset($_GET['search']) && $_GET['searchphrase'])
{
	$searchphrase = $_GET['searchphrase'];
	$all_announcements = "SELECT * FROM `announcements` WHERE `title` LIKE '%{$searchphrase}%' OR `location` LIKE '%{$searchphrase}%' OR `price` LIKE '%{$searchphrase}%' OR `telephone` LIKE '%{$searchphrase}%' OR `description`  LIKE '%{$searchphrase}%' OR `sale_rent` LIKE '%{$searchphrase}%'";
	// echo $all_announcements."<br> search <br>";
}
elseif(isset($_GET['sorting']))
{
	$sorting = $_GET['sorting'];
	$all_announcements = "SELECT * FROM `announcements` $sorting";
	// echo $all_announcements. "<br> soring <br>";
}
elseif (isset($_GET['filtering']))
{
	$filtering = $_GET['filtering'];
	$all_announcements = "SELECT * FROM `announcements` $filtering ";
	// echo $all_announcements. "<br> filtering <br>";;
}
else
{
	$all_announcements = "SELECT * FROM `announcements`";
	// echo $all_announcements. "<br> none <br>";;
}


$NO = 1;

$query = $conn->query($all_announcements);
$images = [
	'https://images.unsplash.com/photo-1593696140826-c58b021acf8b?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=2250&q=80',
	'https://images.unsplash.com/photo-1558036117-15d82a90b9b1?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=2250&q=80',
	'https://images.unsplash.com/photo-1560184897-ae75f418493e?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=2250&q=80',
	'https://images.unsplash.com/photo-1592595896551-12b371d546d5?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=2250&q=80',
	'https://images.unsplash.com/photo-1599809275671-b5942cabc7a2?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=2250&q=80'
];

if (mysqli_num_rows($query)==0)

{
	echo "<h2 style='color: blue'> There are no announcements yet</h2>";
}
?>
	<div class="row list-group">
	<?php
	if ($query)
	{
		while ($announcements = mysqli_fetch_assoc ($query))
		{
			$title = $announcements['title'];
			$price = $announcements['price'];
			$location = $announcements['location'];
			$telephone = $announcements['telephone'];
			$description = $announcements['description'];
			$image = $announcements['images'];
			$for = $announcements['sale_rent'];
	?>
		<div name = 'announcement' class="item  col-xs-4 col-lg-4">
			<div class="thumbnail">
				<img class="group list-group-image" src="<?php echo $images[$NO];?>" alt="" />
				<h3 class="group inner lead text-center"><?php echo $title ?> for <?php echo $for; ?> </h3>
				<p  class="group inner list-group-item-heading"><b>Price:</b> $<?php echo $price ?></p>
				<p  class="group inner list-group-item-text"><b>Location:</b> <?php echo $location ?></p>
				<p  class="group inner list-group-item-text"><b>Phone number:</b> <?php echo $telephone ?></p>
				<p  class="group inner list-group-item-text"><b>Description:</b> <?php echo $description ?></p>
				<p> <?php if ($image){ echo'<img style="width: 100px" src="uploads/'.$image.'">';} ?> </p>
			</div>
		</div>
	<?php
		$NO++;
		}
	}
	?>
	<div>
</div>
</body>
</html>