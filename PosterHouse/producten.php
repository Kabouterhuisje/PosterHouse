<?php
session_start();
$connect = mysqli_connect("localhost", "root", "", "posterhouse_databaseV4");

if (isset($_SESSION['userSession'])) {
    $query = $connect->query("SELECT * FROM user WHERE user_id=".$_SESSION['userSession']);
    $userRow=$query->fetch_array();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Welcome</title>
        <!-- Verwijzingen -->
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen">
        <link rel="stylesheet" href="style.css" type="text/css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    </head>
<body>

<?php
require 'header.php';
?>

<!-- sidemenu -->
<!-- style="margin-top:12%;text-align:left; -->
<div class="collapse navbar-collapse" id="bs-sidebar-navbar-collapse-1" style="margin-top:12%; text-align:left;">
	<h4>Filter op categorie</h4>
      	<ul class="nav navbar-nav">
	      	<div class="col-lg-16">
	      	<?php 
	      	
			$query = "SELECT * FROM category";
			$subquery = "";
			$result = mysqli_query($connect, $query);
			$num_rows = mysqli_num_rows($result);
			
			if($num_rows > 0)
			{
				while($row = mysqli_fetch_array($result))
				{
					echo "<form action='producten.php' method='get'>";
						echo "<li><a href='producten.php?category=".$row['category_name']."'><p>".$row['category_name']."</p></a></li>";
					echo "</form>";
				       	
					$subquery = "SELECT * FROM subcategory where Category_id = ".$row['id'];
					$subresult = mysqli_query($connect, $subquery);
					$num_rows = mysqli_num_rows($result);
					 
					if($num_rows > 0)
					{
						while($row = mysqli_fetch_array($subresult))
						{
							echo "<form action='producten.php' method='get'>";
								echo "<li style='margin-left:10%'><a href='producten.php?subcategory=".$row['subcategory_name']."'><p>".$row['subcategory_name']."</p></a></li>";
							echo "</form>";
						}
					}
	        	}
	        }
			 ?>
	        </div>
     	 </ul>
</div>

<!-- artikelen -->
<div class="container">
	<div class="row" style="margin-bottom:2%; text-align:center;">
		<h2>Artikelen</h2>
	</div>
	<?php 
	// Kijken of er een request uit btnsearch komt
	if (isset($_GET['btnsearch']))
	{
		$query = "SELECT * FROM product WHERE product_name LIKE '%" . $_GET['searchbar'] . "%'";
	}
	else if (isset($_GET['category']))
	{
		$query = "SELECT * FROM product JOIN product_has_category ON product_has_category.Product_id = product.id"
    			." JOIN category ON category.id = product_has_category.Category_id where category_name = '" . $_GET['category'] . "'";

	}
	else if (isset($_GET['subcategory']))
	{
		$query = "SELECT * FROM product JOIN product_has_category ON product_has_category.Product_id = product.id"
        		." JOIN category ON category.id = product_has_category.Category_id JOIN subcategory ON subcategory.Category_id = category.id"
        		." where subcategory_name = '" . $_GET['subcategory'] . "'";
	}
	// Zoniet dat laten we alle producten zien
	else
	{
		$query = "SELECT * FROM product";
	}
	$result = mysqli_query($connect, $query);
	$num_rows = mysqli_num_rows($result);
	
	// De hoeveelheid resultaten die we per pagina willen laten zien
	$countresults = 8;
	
	// De hoeveelheid pagina's die we nodig hebben
	$countpages = ceil($num_rows / $countresults);
	
	// Het bepalen op welke pagina de gebruiker zit
	if(!isset($_GET['page']))
	{
		$page = 1;
	}
	else
	{
		$page = $_GET['page'];
	}
	
	// Het bepalen van het sql LIMIT startcijfer
	$firstresult = ($page - 1) * $countresults;
	
	// Het ophalen van de geselecteerde resultaten uit de database
	if (isset($_GET['btnsearch']))
	{
		$query = "SELECT * FROM product WHERE product_name LIKE '%" . $_GET['searchbar'] . "%' LIMIT " . $firstresult . ',' . $countresults;
	}
	else if (isset($_GET['category']))
	{
		$query = "SELECT * FROM `product` JOIN product_has_category ON product_has_category.Product_id = product.id"
				." JOIN category ON category.id = product_has_category.Category_id where category_name = '" . $_GET['category'] . "'"
				." LIMIT " . $firstresult . ',' . $countresults;
	}
	else if (isset($_GET['subcategory']))
	{
		$query = "SELECT * FROM product JOIN product_has_category ON product_has_category.Product_id = product.id"
				." JOIN category ON category.id = product_has_category.Category_id JOIN subcategory ON subcategory.Category_id = category.id"
				." where subcategory_name = '" . $_GET['subcategory'] . "'"
				." LIMIT " . $firstresult . ',' . $countresults;					
	}
	else
	{
		$query = "SELECT * FROM product LIMIT " . $firstresult . ',' . $countresults;
	}
	$result = mysqli_query($connect, $query);

	if($num_rows > 0)
	{
		for ($i = 0; $i < $num_rows; $i++)
		{
			while($row = mysqli_fetch_array($result))
			{
	?>
    <form method="post" action="winkelmandje.php?action=add&id=<?php echo $row["id"]; ?>">
	<div class="col-xs-6 col-md-3" align="center">
		<img src="images/posters/<?php echo $row['image'];?>" height="250" width="180"/>
        <p><?php echo "€".$row['price'];?></p>
        <a href="productdetails.php?id=<?php echo $row['id'];?>"><?php echo $row['product_name'];?></a>
	</div>
    </form>
	<?php 
			}
		}
	}
	?>
</div>

<!-- Paginering -->
<div class="fixed-bottom">
    <div class="container center">
        <ul class="pagination">
          <?php
          // Het weergeven van de links naar de pagina's
          for ($page=1; $page<=$countpages; $page++)
          {
          	if ($num_rows > $countresults)
          	{
          	echo '<li><a href="producten.php?page=' . $page . '">' . $page . '</a></li>';
          	}
          }
          ?>
        </ul>
    </div>
</div>

<?php
require 'footer.php';
?>
</body>
</html>