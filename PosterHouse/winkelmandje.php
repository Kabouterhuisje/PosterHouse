<?php
session_start();
include 'dbconnect.php';
include 'ClWinkelmandje.php';

if (isset($_SESSION['userSession'])) {
    $query = $connect->query("SELECT * FROM user WHERE user_id=".$_SESSION['userSession']);
    $userRow=$query->fetch_array();
}

$winkelmandje = new ShoppingCart();

if(isset($_POST["add_to_cart"]))
{
    $winkelmandje->addToCard();
}
if(isset($_GET["action"]))
{
    $winkelmandje->deleteFromCard();
}

if(isset($_POST['checkout']) && isset($_SESSION['shopping_cart'])) {

    $winkelmandje->checkout($connect);
}

if(isset($_POST['verder'])) {
    echo '<script>window.location="producten.php"</script>';
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Winkelmandje</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
<body>
<?php
require 'header.php';
?>
<br /><br /><br />
<div class="container" style="width:700px;">
    <h3>Order Details</h3>
    <?php echo "<form method='post'>"; ?>
    <div class="table-responsive">
        <table class="table table-bordered">
            <tr>
                <th width="40%">Productnaam</th>
                <th width="10%">Aantal</th>
                <th width="20%">Prijs</th>
                <th width="15%">Totaal</th>
                <th width="5%">Actie</th>
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
                        <td><input type="number" name="quantity" min="1" value="<?php echo $values["item_quantity"]; ?>"></td>
                        <td>$ <?php echo $values["item_price"]; ?></td>
                        <td>$ <?php echo number_format($values["item_quantity"] * $values["item_price"], 2); ?></td>
                        <td><a href="winkelmandje.php?action=delete&id=<?php echo $values["item_id"]; ?>"><span class="text-danger">Remove</span></a></td>
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
            ?>
        </table>
    </div>
    <?php


    echo "<input type='submit' name='checkout' style='margin-top:5px;' class='btn btn-success' value='Afrekenen' />";
    echo "<input type='submit' name='verder' style='margin-top:5px;' class='btn btn-primary' value='Verder winkelen' />";
    echo "</form>";
    echo "<br /><b><p style='color: red'>Wij maken gebruik van de gegevens die u heeft opgeslagen in uw account. <br /> Controleer voordat u een bestelling plaatst of deze gegevens nog kloppen!</p></b>";

    if(isset($_POST['quantity'])) {
        $_SESSION['updatedQuantity'] = $_POST['quantity'];
    }

    ?>
</div>
<br />
<?php
require 'footer.php';
?>
</body>
</html>