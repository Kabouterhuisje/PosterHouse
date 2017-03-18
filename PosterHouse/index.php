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
</head>
<body style="padding-bottom: 167px;">

<?php
require 'header.php';
?>

<!-- carousel -->
<div class="container" style="margin-top:60px;text-align:center;font-family:Verdana, Geneva, sans-serif;font-size:35px;">
    <p>Aanbiedingen</p>
    <div class="row">
        <div class="col-sm-12">
            <div id="my-slider" class="carousel slide" data-ride="carousel">
                <!--  controls (bolletjes) -->
                <ol class="carousel-indicators">
                    <li data-target="#my-slider" data-slide-to="0" class="active"></li>
                    <li data-target="#my-slider" data-slide-to="1"></li>
                    <li data-target="#my-slider" data-slide-to="2"></li>
                </ol>
                <!-- images -->
                <div class="carousel-inner" role="listbox">
                    <div class="item active">
                        <img class="img-responsive center-block" src="images/aanbieding1.png" alt="carousel1"/>
                    </div>
                    <div class="item">
                        <img class="img-responsive center-block" src="images/aanbieding2.png" alt="carousel2"/>
                    </div>
                    <div class="item">
                        <img class="img-responsive center-block" src="images/aanbieding3.png" alt="carousel3"/>
                    </div>
                </div>
                <!-- controls (links en rechts) -->
                <a class="left carousel-control" href="#my-slider" role="button" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="right carousel-control" href="#my-slider" role="button" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
    </div>
</div>

<?php
require 'footer.php';

?>

</body>
</html>

