<?php
session_start();
include 'dbconnect.php';
include 'ClWinkelmandje.php';

if (isset($_SESSION['userSession'])) {
    $query = $connect->query("SELECT * FROM user WHERE user_id=".$_SESSION['userSession']);
    $userRow=$query->fetch_array();
}

$winkelmandje = new ShoppingCart();

if(isset($_POST['closeOveriew'])) {
    $winkelmandje->closeOverview();
    echo '<script>window.location="index.php"</script>';
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Order Overview</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container"><br /><br /><br /><br />
    <div class="jumbotron">
        <h1>Bedankt voor je bestelling!</h1>
        <p>Hieronder vind je een overzicht van uw bestelling.<br />
            Heeft u klachten over uw bestelling of bent u niet tevreden met het resultaat?<br />
            Neem dan contact op met onze deskundige door <b><a href="contact.php">hier</a></b> te klikken!
        </p>
    </div>
    <h2>Overzicht van uw bestelling:</h2>
    <table class="table table-bordered">
        <tr>
            <th width="40%">Productnaam</th>
            <th width="10%">Aantal</th>
            <th width="20%">Prijs</th>
            <th width="15%">Totaal</th>
        </tr>
        <?php
        $winkelmandje->viewShoppingCart($connect);
        ?>
    </table><br />
    <form method="post">
    <input type='submit' name='closeOveriew' style='margin-top:5px;' class='btn btn-success' value='Klik hier om door te gaan' />
    </form>
</div>
</body>
</html>

