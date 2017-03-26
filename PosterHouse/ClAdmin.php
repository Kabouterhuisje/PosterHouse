<?php

class Admin {
    public function viewProducts($DBconnect) {
        $query = "SELECT * FROM product ORDER BY id";
        $result = mysqli_query($DBconnect, $query);
        $num_rows = mysqli_num_rows($result);

        while ($row = mysqli_fetch_array($result)) {
            echo "<div class='col-xs-6 col-md-3' align='center'>";
            echo "<img src='images/posters/" . $row['image'] . "' height='250' width='180'/>";
            echo "<p><b>Prijs:</b> €<input type='number' step='any' name='productPrice[]' value='" . $row['price'] . "'</p>";
            echo "<p><b>Product:</b> <input type='text' name='productName[]' value='" . $row['product_name'] . "' </p>";
            echo "<p><b>Beschrijving:</b> <input type='text' name='productDescription[]' value='" . $row['description'] . "' </p>";

            // We slaan de query om de bijbehorende subcategorie naam van het product op te halen op in een variabele
            $selectedSubCatQuery = $DBconnect->query("SELECT * FROM subcategory AS sc"
                ." JOIN category AS c ON c.id = sc.Category_id"
                ." JOIN product_has_category AS phc ON phc.Category_id = c.id"
                ." WHERE phc.Product_id = '".$row['id']."'");
            $selectedSubCatRow = $selectedSubCatQuery->fetch_array();

            // Dropdownlist voor subcategorie
            $subCatQuery = ("SELECT * FROM subcategory");
            $subCatResult = mysqli_query($DBconnect, $subCatQuery);
            $select = "<p><b>SubCategorie:</b> <select name='productSubCategory[]'  style='width: 174px;'>";
            // Loopt door alle rows van subcategory
            while ($subCatRow = mysqli_fetch_array($subCatResult))
            {
                // Checkt of het id van het product gelijk is aan een id uit de subcategory table
                if ($subCatRow['id'] == $selectedSubCatRow['id'])
                {
                    // Als de id's overeenkomen dan wordt het toegevoegd aan de dropdownlist als selected value
                    $select.= "<option selected value='".$subCatRow['subcategory_name']."'>".$subCatRow['subcategory_name']."</option>";
                }
                else
                {
                    // Als de id's niet overeenkomen dan wordt het alleen toegevoegd aan de dropdownlist
                    $select.= "<option value='".$subCatRow['subcategory_name']."'>".$subCatRow['subcategory_name']."</option>";
                }
            }
            $select.= "</select></p>";
            echo $select;

            $checkValueProd = $row['id'];
            echo "<br /><input type='checkbox' name='checkboxProd[]' value='$checkValueProd' style='margin-top:5px;' />";
            echo "</div>";
        }
    }

    public function deleteProducts($DBconnect) {
        foreach ($_POST['checkboxProd'] as $del_id) {
            $del_id = (int)$del_id;
            if ($DBconnect->query("DELETE FROM product WHERE id = $del_id")) {
                if ($DBconnect->query("DELETE FROM product_has_category WHERE Product_id = $del_id")) {
                    echo '<script>alert("succes");</script>';
                }
            } else {
                echo '<script>alert("error");</script>';
            }
        }
    }

    public function updateProducts($DBconnect) {
        $x = 0;
        foreach ($_POST['checkboxProd'] as $up_id) {
            $up_id = (int)$up_id;
            foreach ($_POST['productName'] as $prodName) {
                $x++;
                if ($x == $up_id) {
                    $DBconnect->query("UPDATE product SET product_name = '" . $prodName . "' WHERE id = $up_id");
                }
            }
            $x = 0;
            foreach ($_POST['productPrice'] as $prodPrice) {
                $x++;
                if ($x == $up_id) {
                    $DBconnect->query("UPDATE product SET price = " . $prodPrice . " WHERE id = $up_id");
                }
            }
            $x = 0;
            foreach ($_POST['productDescription'] as $prodDescription) {
                $x++;
                if ($x == $up_id) {
                    $DBconnect->query("UPDATE product SET description = '" . $prodDescription . "' WHERE id = $up_id");
                }
            }
            $x = 0;
            foreach ($_POST['productSubCategory'] as $prodSubCategory) {
                $x++;
                if ($x == $up_id) {
                    // Bepalen wat de Category_id is aan de hand van de volgende query
                    $catNameQuery = $DBconnect->query("SELECT c.id FROM category AS c"
                        ." JOIN subcategory AS sc ON sc.Category_id = c.id"
                        ." WHERE sc.subcategory_name = '".$prodSubCategory."';");
                    $catNameRow = $catNameQuery->fetch_array();
                    $DBconnect->query("UPDATE product_has_category SET Category_id = " . $catNameRow['id'] . " WHERE Product_id = $up_id");
                }
            }
        }
    }

    public function viewCategorys($DBconnect) {

        $query = "SELECT * FROM category";
        $result = mysqli_query($DBconnect, $query);

        echo "<form method='post'>";
        while ($row = mysqli_fetch_array($result)) {

            echo "<li><input type='text' name='catName[]' value='" . $row['category_name'] . "'</li>";
            $checkValueCat = $row['id'];
            echo "<input type='checkbox' name='checkboxCat[]' value='$checkValueCat' style='margin-top:5px;' />";

            $subquery = "SELECT * FROM subcategory where Category_id = " . $row['id'];
            $subresult = mysqli_query($DBconnect, $subquery);

            while ($row = mysqli_fetch_array($subresult)) {
                echo "<li style='margin-left:10%'><input type='text' name='subCatName[]' value='" . $row['subcategory_name'] . "' </li>";
                $checkValue = $row['id'];
                echo "<input type='checkbox' name='checkbox[]' value='$checkValue' style='margin-top:5px;' />";
            }

        }
        echo "<br /><input type='submit' name='updateCategory' style='margin-top:5px;' class='btn btn-warning' value='Update category' />&nbsp;";
        echo "<input type='submit' name='deleteCategory' style='margin-top:5px;' class='btn btn-danger' value='Delete category' /><br />";

        echo "<input type='submit' name='updateSubCategory' style='margin-top:5px;' class='btn btn-warning' value='Update subcategory' />&nbsp;";
        echo "<input type='submit' name='deleteSubCategory' style='margin-top:5px;' class='btn btn-danger' value='Delete subcategory' />";

        echo "</form><br />";
    }

    public function deleteCategorys($DBconnect) {
        foreach ($_POST['checkboxCat'] as $del_id) {
            $del_id = (int)$del_id;
            if ($DBconnect->query("DELETE FROM category WHERE id = $del_id") && $DBconnect->query("DELETE FROM subcategory WHERE Category_id = $del_id")) {
                echo '<script>alert("succes");</script>';
            } else {
                echo '<script>alert("error");</script>';
            }
        }
    }

    public function deleteSubCategorys($DBconnect) {
        foreach ($_POST['checkbox'] as $del_id) {
            $del_id = (int)$del_id;
            if ($DBconnect->query("DELETE FROM subcategory WHERE id = $del_id")) {
                echo '<script>alert("succes");</script>';
            } else {
                echo '<script>alert("error");</script>';
            }
        }
    }

    public function updateCategorys($DBconnect) {
        foreach ($_POST['checkboxCat'] as $up_id) {
            $up_id = (int)$up_id;
            foreach ($_POST['catName'] as $catName) {
                $DBconnect->query("UPDATE category SET category_name = '" . $catName . "' WHERE id = $up_id");
            }

        }
    }

    public function updateSubCategorys($DBconnect) {
        foreach ($_POST['checkbox'] as $up_id) {
            $up_id = (int)$up_id;

            foreach ($_POST['subCatName'] as $subCatName) {
                $query = $DBconnect->query("UPDATE subcategory SET subcategory_name = '" . $subCatName . "' WHERE id = $up_id");
            }
        }
    }

    public function viewOrders($DBconnect) {
        $query = "SELECT * FROM `order`";
        $result = mysqli_query($DBconnect, $query);

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
    }

    public function deleteOrders($DBconnect) {
        foreach ($_POST['checkbox'] as $del_id) {
            $del_id = (int)$del_id;
            $query = $DBconnect->query("DELETE FROM `order` WHERE id = $del_id");
        }
    }
}

?>