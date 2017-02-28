<?php
session_start();
include_once 'dbconnect.php';

if (isset($_SESSION['userSession'])) {
    $query = $DBcon->query("SELECT * FROM user WHERE user_id=".$_SESSION['userSession']);
    $userRow=$query->fetch_array();
}

$DBcon->close();

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
</head>
<body>

<?php
require 'header.php';
?>

<!-- sidemenu -->
<!-- style="margin-top:12%;text-align:left; -->
<div class="collapse navbar-collapse" id="bs-sidebar-navbar-collapse-1">
	<p>Filter op categorie</p>
      <ul class="nav navbar-nav">
      <div class="col-lg-3">
        <li data-toggle="collapse" data-target="#dieren" class="collapsed">
                  <a href="#"><i class="fa fa-globe fa-lg"></i>Dieren<span class="arrow"></span></a>
        </li>  
        <ul class="sub-menu collapse" id="dieren">
           <li>Poezen</li>
           <li>Koraalwormen</li>
         </ul>  
         <li data-toggle="collapse" data-target="#quotes" class="collapsed">
                  <a href="#"><i class="fa fa-globe fa-lg"></i>Quotes<span class="arrow"></span></a>
        </li>      
         <ul class="sub-menu collapse" id="quotes">
           <li>Leven</li>
           <li>Trump</li>
         </ul>  
         <li data-toggle="collapse" data-target="#natuurwonderen" class="collapsed">
                  <a href="#"><i class="fa fa-globe fa-lg"></i>Natuurwonderen<span class="arrow"></span></a>
        </li>  
         <ul class="sub-menu collapse" id="natuurwonderen">
           <li>Honden</li>
           <li>Wereld</li>
         </ul>  
         <li data-toggle="collapse" data-target="#muziek" class="collapsed">
                  <a href="#"><i class="fa fa-globe fa-lg"></i>Muziek<span class="arrow"></span></a>
        </li>  
         <ul class="sub-menu collapse" id="muziek">
           <li>Smurfenhouse</li>
           <li>Techno</li>
           <li>Pop</li>
         </ul>    
        </div>
      </ul>
    </div>
</div>

<!-- artikelen -->
<div class="container">
	<div class="row" style="margin-bottom:2%; text-align:center;">
		<h2>Artikelen</h2>
	</div>
	<div class="row">
		<div class="col-xs-6 col-md-3">
			<img src="images/artikel.png"/>
			<p>Placeholder</p>
		</div>
		<div class="col-xs-6 col-md-3">
			<img src="images/artikel.png"/>
			<p>Placeholder</p>
		</div>
		<div class="col-xs-6 col-md-3">
			<img src="images/artikel.png"/>
			<p>Placeholder</p>
		</div>
		<div class="col-xs-6 col-md-3">
			<img src="images/artikel.png"/>
			<p>Placeholder</p>
		</div>
	</div>	
	<div class="row">
		<div class="col-xs-6 col-md-3">
			<img src="images/artikel.png"/>
			<p>Placeholder</p>
		</div>
		<div class="col-xs-6 col-md-3">
			<img src="images/artikel.png"/>
			<p>Placeholder</p>
		</div>
		<div class="col-xs-6 col-md-3">
			<img src="images/artikel.png"/>
			<p>Placeholder</p>
		</div>
		<div class="col-xs-6 col-md-3">
			<img src="images/artikel.png"/>
			<p>Placeholder</p>
		</div>
	</div>	
</div>

<!-- Paginering -->
<div class="fixed-bottom">
<div class="container center">
<ul class="pagination">
  <li><a href="#">1</a></li>
  <li><a href="#">2</a></li>
  <li><a href="#">3</a></li>
  <li><a href="#">4</a></li>
  <li><a href="#">5</a></li>
</ul>
</div>
</div>

<?php
require 'footer.php';
?>
</body>
</html>