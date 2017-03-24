<?php
session_start();
$connect = mysqli_connect("localhost", "root", "", "posterhouse_databaseV5");

if (isset($_SESSION['userSession'])) {
    $query = $connect->query("SELECT * FROM user WHERE user_id=".$_SESSION['userSession']);
    $userRow=$query->fetch_array();
}

if ($userRow['role'] == 'Admin'){
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin</title>
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
<div class="container"><br/><br/><br/><br/>

    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#home">Home</a></li>
        <li><a data-toggle="tab" href="#menu1">Producten</a></li>
        <li><a data-toggle="tab" href="#menu2">Categoriën</a></li>
        <li><a data-toggle="tab" href="#menu3">Bestellingen</a></li>
    </ul>

    <div class="tab-content">
        <div id="home" class="tab-pane fade in active"><br/>
            <div class="jumbotron">
                <h1>Welkom, administrator!</h1>
                <p>U bevind zich op het admin panel. Beheer makkelijk de webshop door dingen toe te voegen, verwijderen
                    of wijzigen. Klik op een tab om aan de slag te gaan!</p>
            </div>
        </div>
        <div id="menu1" class="tab-pane fade">
            <!-- artikelen -->
            <div class="col-sm-6" style="margin-bottom:2%; text-align:center;">
                <form method='post' style='margin-right: -400px'>
                    <h2>Producten <input type='submit' name='addProduct' style='margin-top:5px;' class='btn btn-success'
                                         value='Add'/>
                        <input type='submit' name='updateProduct' style='margin-top:5px;' class='btn btn-warning'
                               value='Update'/>
                        <input type='submit' name='deleteProduct' style='margin-top:5px;' class='btn btn-danger'
                               value='Delete'/>
                    </h2>

                    <?php

                    $query = "SELECT * FROM product ORDER BY id";
                    $result = mysqli_query($connect, $query);
                    $num_rows = mysqli_num_rows($result);

                    if ($num_rows > 0)
                    {
                    while ($row = mysqli_fetch_array($result)) {
                        echo "<div class='col-xs-6 col-md-3' align='center'>";
                        echo "<img src='images/posters/" . $row['image'] . "' height='250' width='180'/>";
                        echo "<p><b>Prijs:</b> €<input type='number' step='any' name='productPrice[]' value='" . $row['price'] . "'</p>";
                        echo "<p><b>Product:</b> <input type='text' name='productName[]' value='" . $row['product_name'] . "' </p>";
                        echo "<p><b>Beschrijving:</b> <input type='text' name='productDescription[]' value='" . $row['description'] . "' </p>";
                        
                        // We slaan de query om de bijbehorende categorie naam van het product op te halen op in een variabele
                        $selectedCatQuery = $connect->query("SELECT * FROM category AS c"
        													." JOIN product_has_category AS phc ON phc.Category_id = c.id"
        													." WHERE phc.Product_id = '".$row['id']."';");
                        $selectedCatRow = $selectedCatQuery->fetch_array();
                        // We slaan de query om de bijbehorende subcategorie naam van het product op te halen op in een variabele
                        $selectedSubCatQuery = $connect->query("SELECT * FROM subcategory AS sc"
                        									   ." JOIN category AS c ON c.id = sc.Category_id"
                        									   ." JOIN product_has_category AS phc ON phc.Category_id = c.id"
                        									   ." WHERE phc.Product_id = '".$row['id']."'");
                        $selectedSubCatRow = $selectedSubCatQuery->fetch_array();
                        
                        // Dropdownlist voor categorie
                        $catQuery = ("SELECT * FROM category");
                        $catResult = mysqli_query($connect, $catQuery);
                        $select = "<p><b>Categorie:</b> <select name='productCategory[]' style='width: 174px;'>";
                        // Loopt door alle rows van category
                        while ($row = mysqli_fetch_array($catResult))
                        {
                        	// Checkt of het id van het product gelijk is aan een id uit de category table
                        	if ($row['id'] == $selectedCatRow['id'])
                        	{
                        		// Als de id's overeenkomen dan wordt het toegevoegd aan de dropdownlist als selected value
                        		$select.= "<option selected value='".$row['category_name']."'>".$row['category_name']."</option>";
                        	}
                        	else
                        	{
                        		// Als de id's niet overeenkomen dan wordt het alleen toegevoegd aan de dropdownlist
                        		$select.= "<option value='".$row['category_name']."'>".$row['category_name']."</option>";
                        	}
                        }
                        $select.= "</select></p>";
                        echo $select;
                        
                        // Dropdownlist voor subcategorie
                        $subCatQuery = ("SELECT * FROM subcategory");
                        $subCatResult = mysqli_query($connect, $subCatQuery);
                        $select = "<p><b>SubCategorie:</b> <select name='productSubCategory[]'  style='width: 174px;'>";
                        // Loopt door alle rows van subcategory
                        while ($row = mysqli_fetch_array($subCatResult))
                        {
                        	// Checkt of het id van het product gelijk is aan een id uit de subcategory table
                        	if ($row['id'] == $selectedSubCatRow['id'])
                        	{
                        		// Als de id's overeenkomen dan wordt het toegevoegd aan de dropdownlist als selected value
                        		$select.= "<option selected value='".$row['subcategory_name']."'>".$row['subcategory_name']."</option>";
                        	}
                        	else
                        	{
                        		// Als de id's niet overeenkomen dan wordt het alleen toegevoegd aan de dropdownlist
                        		$select.= "<option value='".$row['subcategory_name']."'>".$row['subcategory_name']."</option>";
                        	}
                        }
                        $select.= "</select></p>";
                        echo $select;
                        
                        $checkValueProd = $row['id'];
                        echo "<br /><input type='checkbox' name='checkboxProd[]' value='$checkValueProd' style='margin-top:5px;' />";
                        echo "</div>";
                    }
                    ?>
                </form>
                <?php

                if (isset($_POST['addProduct'])) {
                    echo '<script>window.location="addProduct.php"</script>';
                }

                if (isset($_POST['deleteProduct']) && isset($_POST['checkboxProd'])) {
                    foreach ($_POST['checkboxProd'] as $del_id) {
                        $del_id = (int)$del_id;
                        if ($connect->query("DELETE FROM product WHERE id = $del_id")) {
                            echo '<script>alert("succes");</script>';
                        } else {
                            echo '<script>alert("error");</script>';
                        }
                    }
                    echo '<script>window.location="admin.php"</script>';
                }

                if (isset($_POST['updateProduct']) && isset($_POST['checkboxProd'])) {
                    $x = 0;
                    foreach ($_POST['checkboxProd'] as $up_id) {
                        $up_id = (int)$up_id;
                        foreach ($_POST['productName'] as $prodName) {
                            $x++;
                            if ($x == $up_id) {
                                $connect->query("UPDATE product SET product_name = '" . $prodName . "' WHERE id = $up_id");
                            }
                        }
                        $x = 0;
                        foreach ($_POST['productPrice'] as $prodPrice) {
                            $x++;
                            if ($x == $up_id) {
                                $connect->query("UPDATE product SET price = " . $prodPrice . " WHERE id = $up_id");
                            }
                        }
                        $x = 0;
                        foreach ($_POST['productDescription'] as $prodDescription) {
                            $x++;
                            if ($x == $up_id) {
                                $connect->query("UPDATE product SET description = '" . $prodDescription . "' WHERE id = $up_id");
                            }
                        }
                        $x = 0;
                        foreach ($_POST['productCategory'] as $prodCategory) {
                            $x++;
                            if ($x == $up_id) {
                                $connect->query("UPDATE product_has_category SET Category_id = " . $prodCategory . " WHERE Product_id = $up_id");
                            }
                        }
                        $x = 0;
                        foreach ($_POST['productSubCategory'] as $prodSubCategory) {
                            $x++;
                            if ($x == $up_id) {
                                $connect->query("UPDATE subcategory SET Product_id = " . $prodSubCategory . " WHERE id = $up_id");
                            }
                        }
                    }
                    echo '<script>window.location="admin.php"</script>';
                }
                }
                ?>
            </div>
        </div>
        <div id="menu2" class="tab-pane fade"><br/>
            <form method="post" action="addCategory.php">
                <h2>Categorieën <input type='submit' name='addCategory' style='margin-top:5px;' class='btn btn-success'
                                       value='Add'/></h2>
            </form>
            <?php

            $query = "SELECT * FROM category";
            $subquery = "";
            $result = mysqli_query($connect, $query);
            $num_rows = mysqli_num_rows($result);

            if ($num_rows > 0) {
                echo "<form method='post'>";
                while ($row = mysqli_fetch_array($result)) {

                    echo "<li><input type='text' name='catName[]' value='" . $row['category_name'] . "'</li>";
                    $checkValueCat = $row['id'];
                    echo "<input type='checkbox' name='checkboxCat[]' value='$checkValueCat' style='margin-top:5px;' />";


                    $subquery = "SELECT * FROM subcategory where Category_id = " . $row['id'];
                    $subresult = mysqli_query($connect, $subquery);
                    $num_rows = mysqli_num_rows($result);

                    if ($num_rows > 0) {
                        while ($row = mysqli_fetch_array($subresult)) {
                            echo "<li style='margin-left:10%'><input type='text' name='subCatName[]' value='" . $row['subcategory_name'] . "' </li>";
                            $checkValue = $row['id'];
                            echo "<input type='checkbox' name='checkbox[]' value='$checkValue' style='margin-top:5px;' />";
                        }
                    }
                }
                echo "<br /><input type='submit' name='updateCategory' style='margin-top:5px;' class='btn btn-warning' value='Update category' />&nbsp;";
                echo "<input type='submit' name='deleteCategory' style='margin-top:5px;' class='btn btn-danger' value='Delete category' /><br />";

                echo "<input type='submit' name='updateSubCategory' style='margin-top:5px;' class='btn btn-warning' value='Update subcategory' />&nbsp;";
                echo "<input type='submit' name='deleteSubCategory' style='margin-top:5px;' class='btn btn-danger' value='Delete subcategory' />";

                echo "</form><br />";

                if (isset($_POST['deleteCategory']) && isset($_POST['checkboxCat'])) {
                    foreach ($_POST['checkboxCat'] as $del_id) {
                        $del_id = (int)$del_id;
                        if ($connect->query("DELETE FROM category WHERE id = $del_id") && $connect->query("DELETE FROM subcategory WHERE Category_id = $del_id")) {
                            echo '<script>alert("succes");</script>';
                        } else {
                            echo '<script>alert("error");</script>';
                        }
                    }
                    echo '<script>window.location="admin.php"</script>';
                }

                if (isset($_POST['deleteSubCategory']) && isset($_POST['checkbox'])) {
                    foreach ($_POST['checkbox'] as $del_id) {
                        $del_id = (int)$del_id;
                        if ($connect->query("DELETE FROM subcategory WHERE id = $del_id")) {
                            echo '<script>alert("succes");</script>';
                        } else {
                            echo '<script>alert("error");</script>';
                        }
                    }
                    echo '<script>window.location="admin.php"</script>';
                }

                if (isset($_POST['updateCategory']) && isset($_POST['checkboxCat'])) {
                    foreach ($_POST['checkboxCat'] as $up_id) {
                        $up_id = (int)$up_id;
                        foreach ($_POST['catName'] as $catName) {
                            $connect->query("UPDATE category SET category_name = '" . $catName . "' WHERE id = $up_id");
                        }

                    }
                    echo '<script>window.location="admin.php"</script>';
                }

                if (isset($_POST['updateSubCategory']) && isset($_POST['checkbox'])) {
                    foreach ($_POST['checkbox'] as $up_id) {
                        $up_id = (int)$up_id;

                        foreach ($_POST['subCatName'] as $subCatName) {
                            $query = $connect->query("UPDATE subcategory SET subcategory_name = '" . $subCatName . "' WHERE id = $up_id");
                        }
                    }
                    echo '<script>window.location="admin.php"</script>';
                }
            }
            ?>
        </div>
        <div id="menu3" class="tab-pane fade"><br/>
            <div class="col-sm-12" style="margin-bottom:2%; text-align:center;">
                <form method='post'>
                <h2>Bestellingen <input type='submit' name='deleteOrder' style='margin-top:5px;' class='btn btn-danger' value='Delete' /></h2>

                <?php

                $query = "SELECT * FROM `order`";
                $result = mysqli_query($connect, $query);

                while ($row = mysqli_fetch_array($result)) {
                    echo "<div class='col-xs-6 col-md-3' align='center'>";
                    echo "<p>Order ID: " . $row['id'] . "</p>";
                    echo "<p>Totaalprijs: " . $row['total_price'] . "</p>";
                    echo "<p>Besteldatum: " . $row['date_created'] . "</p>";
                    echo "<p>User ID: " . $row['User_id'] . "</p>";
                    $checkValue = $row['id'];
                    echo "<input type='checkbox' name='checkbox[]' value='$checkValue' style='margin-top:5px;' />";
                    echo "</div>";
                }

                echo "</form><br />";

                if (isset($_POST['deleteOrder'])) {
                    foreach ($_POST['checkbox'] as $del_id) {
                        $del_id = (int)$del_id;
                        $query = $connect->query("DELETE FROM `order` WHERE id = $del_id");
                    }
                    echo '<script>window.location="admin.php"</script>';
                }

                $connect->close();
                ?>
            </div>
        </div>
    </div>
</div>
<?php
}
else {
    echo '<script>window.location="login.php"</script>';
}
require 'footer.php';
?>
</body>
</html>