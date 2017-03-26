<?php
session_start();
include 'dbconnect.php';

if (isset($_SESSION['userSession'])) {
	$query = $DBconnect->query("SELECT * FROM user WHERE user_id=".$_SESSION['userSession']);
	$userRow=$query->fetch_array();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Product details</title>
        <!-- Verwijzingen -->
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen">
        <link rel="stylesheet" href="style.css" type="text/css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
    </head>
<body>

<?php
require 'header.php';
?>

<?php 
		$query = "SELECT * FROM product where id = " . $_GET['id'];
		$result = mysqli_query($DBconnect, $query);
		$row = mysqli_fetch_array($result);
?>

<div class="container-fluid">
    <div class="content-wrapper">	
		<div class="item-container">	
			<div class="container">	
				<div class="col-md-12">
					<div class="img-responsive center-block" style="margin-top:8%;">
					<center>
						<img id="item-display" src="images/posters/<?php echo $row['image'];?>" height="400" width="250"></img>
					</center>
					</div>
				</div>	
				<div style="text-align:center;">
                    <form method="post" action="winkelmandje.php?action=add&id=<?php echo $row['id'];?>">
                    <input type="hidden" name="hidden_name" value="<?php echo $row["product_name"]; ?>" />
                    <input type="hidden" name="hidden_price" value="<?php echo $row["price"]; ?>" />
                    <p><?php echo $row['description'];?></p>
					<div class="btn-group cart">
							<input type="text" name="quantity" class="form-control" value="1" />
	        				<input type="submit" name="add_to_cart" style="margin-top:5px;" class="btn btn-success" value="Add to Cart" />	
        				</form>
					</div>
				</div>
			</div> 
		</div>
	</div>
</div>

<?php
require 'footer.php';
?>

</body>
</html>