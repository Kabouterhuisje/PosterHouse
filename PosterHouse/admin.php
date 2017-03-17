<?php
session_start();
$connect = mysqli_connect("localhost", "root", "", "posterhouse_databaseV4");

if (isset($_SESSION['userSession'])) {
    $query = $connect->query("SELECT * FROM user WHERE user_id=".$_SESSION['userSession']);
    $userRow=$query->fetch_array();
}

$connect->close();

?>
<!DOCTYPE html>
<html>
<head>
    <title>Checkout</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<?php
require 'header.php';
?>
<div class="container"><br /><br /><br /><br />

        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#home">Home</a></li>
            <li><a data-toggle="tab" href="#menu1">Producten</a></li>
            <li><a data-toggle="tab" href="#menu2">Categoriën</a></li>
            <li><a data-toggle="tab" href="#menu3">Subcategoriën</a></li>
            <li><a data-toggle="tab" href="#menu4">Bestellingen</a></li>
        </ul>

        <div class="tab-content">
            <div id="home" class="tab-pane fade in active"><br />
                <div class="jumbotron">
                    <h1>Welkom, administrator!</h1>
                    <p>U bevind zich op het admin panel. Beheer makkelijk de webshop door dingen toe te voegen, verwijderen of wijzigen. Klik op een tab om aan de slag te gaan!</p>
                </div>
            </div>
            <div id="menu1" class="tab-pane fade">
                <h3>Producten</h3>
                <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
            </div>
            <div id="menu2" class="tab-pane fade">
                <h3>Categoriën</h3>
                <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
            </div>
            <div id="menu3" class="tab-pane fade">
                <h3>Subcategoriën</h3>
                <p>Eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
            </div>
            <div id="menu4" class="tab-pane fade">
                <h3>Bestellingen</h3>
                <p>Eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
            </div>
        </div>
</div>
<?php
require 'footer.php';
?>
</body>
</html>