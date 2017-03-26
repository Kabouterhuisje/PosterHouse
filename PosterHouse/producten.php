<?php
session_start();
include 'dbconnect.php';
include 'ClProducten.php';

if (isset($_SESSION['userSession'])) {
    $query = $DBconnect->query("SELECT * FROM user WHERE user_id=".$_SESSION['userSession']);
    $userRow=$query->fetch_array();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Producten</title>
        <!-- Verwijzingen -->
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen">
        <link rel="stylesheet" href="style.css" type="text/css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    </head>
<body style="padding-bottom: 167px;">

<?php
require 'header.php';
?>

<!-- sidemenu -->
<div class="row" style="margin-top:5%;">
	<div class="col-sm-3">
		<div class="collapse navbar-collapse" id="bs-sidebar-navbar-collapse-1" style="text-align:left; overflow:hidden;">
			<h4>Filter op categorie</h4>
	      	<ul class="nav navbar-nav">
		      	<div class="col-lg">
		      	<?php 
		      	$producten = new Producten();
		      	$producten->viewCategoryMenu($DBconnect);
				 ?>
		        </div>
	     	 </ul>
		</div>
	</div>

	<!-- artikelen -->
	<div class="col-sm-6" style="margin-bottom:2%; text-align:center;">
		<h2>Artikelen</h2>
		<?php 
		$producten->viewProducts($DBconnect);
		?>
	</div>
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