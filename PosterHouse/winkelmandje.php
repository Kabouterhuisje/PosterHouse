<?php
session_start();
$connect = mysqli_connect("localhost", "root", "", "posterhouse_databaseV3");

if (isset($_SESSION['userSession'])) {
    $query = $connect->query("SELECT * FROM user WHERE user_id=".$_SESSION['userSession']);
    $userRow=$query->fetch_array();
}

if(isset($_POST["add_to_cart"]))
{
    if(isset($_SESSION["shopping_cart"]))
    {
        $item_array_id = array_column($_SESSION["shopping_cart"], "item_id");
        if(!in_array($_GET["id"], $item_array_id))
        {
            $count = count($_SESSION["shopping_cart"]);
            $item_array = array(
                'item_id' => $_GET["id"],
                'item_name' => $_POST["hidden_name"],
                'item_price' => $_POST["hidden_price"],
                'item_quantity' => $_POST["quantity"]
            );
            $_SESSION["shopping_cart"][$count] = $item_array;
        }
        else
        {
            echo '<script>alert("Item Already Added")</script>';
            echo '<script>window.location="winkelmandje.php"</script>';
        }
    }
    else
    {
        $item_array = array(
            'item_id' => $_GET["id"],
            'item_name' => $_POST["hidden_name"],
            'item_price' => $_POST["hidden_price"],
            'item_quantity' => $_POST["quantity"]
        );
        $_SESSION["shopping_cart"][0] = $item_array;
    }
}
if(isset($_GET["action"]))
{
    if($_GET["action"] == "delete")
    {
        foreach($_SESSION["shopping_cart"] as $keys => $values)
        {
            if($values["item_id"] == $_GET["id"])
            {
                unset($_SESSION["shopping_cart"][$keys]);
                echo '<script>window.location="winkelmandje.php"</script>';
            }
        }
    }
}

if(isset($_POST['checkout'])) {

    $query = "INSERT INTO `order` (total_price,date_created,User_id) VALUES (12.12,CURRENT_DATE,".$_SESSION['userSession'].")";

    if ($connect->query($query)) {
        echo '<script>window.location="order_overview.php"</script>';
    }else {
        echo '<script>alert("error");</script>';
    }

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
                        <td><?php echo $values["item_quantity"]; ?></td>
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
    $locationPage;
    if (isset($_SESSION['userSession'])) {
        $locationPage = "order_overview.php";
    }
    else {
        $locationPage = "login.php";
    }
    echo "<form method='post'>";
    echo "<input type='submit' name='checkout' style='margin-top:5px;' class='btn btn-success' value='Afrekenen' />";
    echo "<input type='submit' name='verder' style='margin-top:5px;' class='btn btn-primary' value='Verder winkelen' />";
    echo "</form>";
    ?>
</div>
<br />
<?php
require 'footer.php';
?>
</body>
</html>