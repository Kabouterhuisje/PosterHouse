<?php
session_start();
$connect = mysqli_connect("localhost", "root", "", "posterhouse_databaseV4");

if (isset($_SESSION['userSession'])) {
    $query = $connect->query("SELECT * FROM user WHERE user_id=".$_SESSION['userSession']);
    $userRow=$query->fetch_array();
}

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
<body style="padding-bottom: 167px;">
<?php
require 'header.php';
?>
<div class="container"><br /><br /><br /><br />

        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#home">Home</a></li>
            <li><a data-toggle="tab" href="#menu1">Producten</a></li>
            <li><a data-toggle="tab" href="#menu2">Categoriën</a></li>
            <li><a data-toggle="tab" href="#menu3">Bestellingen</a></li>
        </ul>

        <div class="tab-content">
            <div id="home" class="tab-pane fade in active"><br />
                <div class="jumbotron">
                    <h1>Welkom, administrator!</h1>
                    <p>U bevind zich op het admin panel. Beheer makkelijk de webshop door dingen toe te voegen, verwijderen of wijzigen. Klik op een tab om aan de slag te gaan!</p>
                </div>
            </div>
            <div id="menu1" class="tab-pane fade">
                <!-- artikelen -->
                <div class="col-sm-6" style="margin-bottom:2%; text-align:center;">
                    <form method="post" action="addProduct.php">
                    <h2>Producten <input type='submit' name='addProduct' style='margin-top:5px;' class='btn btn-success' value='Add' /></h2>
                    </form>
                    <?php

                    $query = "SELECT * FROM product";

                    $result = mysqli_query($connect, $query);

                    while($row = mysqli_fetch_array($result))
                    {
                        echo "<form method='post' style='margin-right: -400px'>";
                        echo "<div class='col-xs-6 col-md-3' align='center'>";
                        echo "<img src='images/posters/".$row['image']."' height='250' width='180'/>";
                        echo "<p><b>Prijs:</b> €<input type='number' step='any' name='p_prijs' value='".$row['price']."'</p>";
                        echo "<p><b>Product:</b> <input type='text' name='p_naam' value='".$row['product_name']."' </p>";
                        echo "<p><b>Beschrijving:</b> <input type='text' name='p_beschrijving' value='".$row['description']."' </p>";
                        $catQuery = $connect->query("SELECT * FROM product_has_category WHERE Product_id = ".$row['id'].";");
                        $catRow = $catQuery->fetch_array();
                        echo "<p><b>Categorie:</b> <input type='number' name='p_category' value='".$catRow['Category_id']."' </p>";
                        $subCatQuery = $connect->query("SELECT * FROM subcategory WHERE Category_id = ".$catRow['Category_id'].";");
                        $subCatRow = $subCatQuery->fetch_array();
                        echo "<p><b>Subcategorie:</b> <input type='number' name='p_subcategory' value='".$subCatRow['id']."' </p>";
                        echo "<input type='submit' name='updateProduct' style='margin-top:5px;' class='btn btn-warning' value='Update' />&nbsp";
                        echo "<input type='submit' name='deleteProduct' style='margin-top:5px;' class='btn btn-danger' value='Delete' />";
                        echo "</div>";
                        echo "</form>";
                    }
                    ?>
                </div>
            </div>
            <div id="menu2" class="tab-pane fade"><br />
                <h2>Categoriën <input type='submit' name='deleteProduct' style='margin-top:5px;' class='btn btn-success' value='Add' /></h2>
                <?php

                $query = "SELECT * FROM category";
                $subquery = "";
                $result = mysqli_query($connect, $query);
                $num_rows = mysqli_num_rows($result);

                if($num_rows > 0)
                {
                    while($row = mysqli_fetch_array($result))
                    {
                        echo "<form method='get'>";
                        echo "<li><input type='text' value='".$row['category_name']."'</li>";
                        echo "<input type='submit' name='updateCategory' style='margin-top:5px;' class='btn btn-warning' value='Update' />";
                        echo "<input type='submit' name='deleteCategory' style='margin-top:5px;' class='btn btn-danger' value='Delete' />";
                        echo "</form><br />";

                        $subquery = "SELECT * FROM subcategory where Category_id = ".$row['id'];
                        $subresult = mysqli_query($connect, $subquery);
                        $num_rows = mysqli_num_rows($result);

                        if($num_rows > 0)
                        {
                            while($row = mysqli_fetch_array($subresult))
                            {
                                echo "<form method='get'>";
                                echo "<li style='margin-left:10%'><input type='text' value='".$row['subcategory_name']."' </li>";
                                echo "<input type='submit' name='updateSubCategory' style='margin-top:5px;' class='btn btn-warning' value='Update' />";
                                echo "<input type='submit' name='deleteSubCategory' style='margin-top:5px;' class='btn btn-danger' value='Delete' />";
                                echo "</form><br />";
                            }
                        }
                    }
                }
                ?>
            </div>
            <div id="menu3" class="tab-pane fade"><br />
                <div class="col-sm-3" style="margin-bottom:2%; text-align:center;">
                <h2>Bestellingen</h2>

                <?php

                $query = "SELECT * FROM `order`";

                $result = mysqli_query($connect, $query);

                while ($row = mysqli_fetch_array($result))
                {
                    echo "<form method='post'>";
                    echo "<p>Order ID: ".$row['id']."</p>";
                    echo "<p>Totaalprijs: ".$row['total_price']."</p>";
                    echo "<p>Besteldatum: ".$row['date_created']."</p>";
                    echo "<p>User ID: ".$row['User_id']."</p>";
                    echo "<input type='submit' name='deleteOrder' style='margin-top:5px;' class='btn btn-danger' value='Delete' />";
                    echo "</form><br />";
                }

                $connect->close();
                ?>
            </div>
            </div>
        </div>
</div>
<?php
require 'footer.php';
?>
</body>
</html>