<?php
session_start();
$connect = mysqli_connect("localhost", "root", "", "posterhouse_databaseV5");

if (isset($_SESSION['userSession'])) {
    $query = $connect->query("SELECT * FROM user WHERE user_id=".$_SESSION['userSession']);
    $userRow=$query->fetch_array();
}

if(isset($_POST['closeOveriew'])) {
    unset($_SESSION['shopping_cart']);
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
        if(!empty($_SESSION["shopping_cart"]))
        {
            $total = 0;
            foreach($_SESSION["shopping_cart"] as $keys => $values)
            {
                ?>
                <tr>
                    <td><?php echo $values["item_name"]; ?></td>
                    <td><?php echo $_SESSION['updatedQuantity']; ?></td>
                    <td>$ <?php echo $values["item_price"]; ?></td>
                    <td>$ <?php echo number_format($values["item_quantity"] * $values["item_price"], 2); ?></td>
                </tr>
                <?php
                $total = $total + ($values["item_quantity"] * $values["item_price"]);
            }
            ?>
            <tr>
                <td colspan="3" align="right">Total</td>
                <td align="right">$ <?php echo number_format($total, 2); ?></td>
                <td></td>
            </tr>
            <?php
        }
        $connect->close();
        ?>
    </table><br />
    <form method="post">
    <input type='submit' name='closeOveriew' style='margin-top:5px;' class='btn btn-success' value='Klik hier om door te gaan' />
    </form>
</div>
</body>
</html>

