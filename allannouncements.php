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

<div class="container">
	<!-- <div class="row"> -->

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
				</ul>
				
				<ul class="nav navbar-nav navbar-right">
					<li>
					<?php
						session_start();

						if (isset($_SESSION["id"])){
							echo "<form action='index.php' method='post'> <input type='submit' name='logout' value='&#xe163;' class='glyphicon'> </form>";
						}

						else
						{
							echo "<form action='signin.php'> <button type='submit'>Sign In</button></form>";
						}
					?>
					</li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Filter by type <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><button class="btn btn-link" onclick="()=>this.form.submit('WHERE `sale_rent`=\'sale\'')">For sale </button></li>
							<li><button class="btn btn-link" onclick="()=>this.form.submit('WHERE `sale_rent`=\'rent\'')"> For rent</button></li>
						</ul>
					</li>
				</ul>

				<form class="navbar-form" role="search">
					<div class="input-group">
						<input type="text" class="form-control" placeholder="Search">
						<span class="input-group-btn">
							<button type="reset" class="btn btn-default">
								<span class="glyphicon glyphicon-remove">
									<span class="sr-only">Close</span>
								</span>
							</button>
							<button type="submit" class="btn btn-default">
								<span class="glyphicon glyphicon-search">
									<span class="sr-only">Search</span>
								</span>
							</button>
						</span>
					</div>
				</form>
			</div><!-- /.navbar-collapse -->
		</div><!-- /.container-fluid -->
	</nav>	
	<!-- </div> -->
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
				<img class="group list-group-image" src="http://placehold.it/400x250/000/fff" alt="" />
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
<script>
    $(function () {
        // Remove Search if user Resets Form or hits Escape!
		$('body, .navbar-collapse form[role="search"] button[type="reset"]').on('click keyup', function(event) {
			console.log(event.currentTarget);
			if (event.which == 27 && $('.navbar-collapse form[role="search"]').hasClass('active') ||
				$(event.currentTarget).attr('type') == 'reset') {
				closeSearch();
			}
		});

		function closeSearch() {
            var $form = $('.navbar-collapse form[role="search"].active')
    		$form.find('input').val('');
			$form.removeClass('active');
		}

		// Show Search if form is not active // event.preventDefault() is important, this prevents the form from submitting
		$(document).on('click', '.navbar-collapse form[role="search"]:not(.active) button[type="submit"]', function(event) {
			event.preventDefault();
			var $form = $(this).closest('form'),
				$input = $form.find('input');
			$form.addClass('active');
			$input.focus();

		});
		// ONLY FOR DEMO // Please use $('form').submit(function(event)) to track from submission
		// if your form is ajax remember to call `closeSearch()` to close the search container
		$(document).on('click', '.navbar-collapse form[role="search"].active button[type="submit"]', function(event) {
			event.preventDefault();
			var $form = $(this).closest('form'),
				$input = $form.find('input');
			$('#showSearchTerm').text($input.val());
            closeSearch()
		});
    });
</script>
</body>
</html>