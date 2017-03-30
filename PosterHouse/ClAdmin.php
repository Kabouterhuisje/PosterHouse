<?php
class Admin {
	// Functie die de producten laat zien
    public function viewProducts($DBconnect) {
    	// Haalt alle producten op uit de database en ordert ze op id
        $query = "SELECT * FROM product ORDER BY id";
        $result = mysqli_query($DBconnect, $query);
        $num_rows = mysqli_num_rows($result);

        // Gaat elk product af
        while ($row = mysqli_fetch_array($result)) 
        {
        	// Vult de producten met gegevens uit de database
            echo "<div class='col-xs-6 col-md-3' align='center'>";
            echo "<img src='images/posters/" . $row['image'] . "' height='250' width='180'/>";
            echo "<p><b>Prijs:</b> €<input required type='number' step='any' name='productPrice[]' min='1' value='" . $row['price'] . "'</p>";
            echo "<p><b>Product:</b> <input required type='text' name='productName[]' value='" . $row['product_name'] . "' </p>";
            echo "<p><b>Beschrijving:</b> <input required type='text' name='productDescription[]' value='" . $row['description'] . "' </p>";

            // Haalt bijbehorende SubCategorieën van het product op
            $selectedSubCatQuery = $DBconnect->query("SELECT * FROM subcategory AS sc"
                ." JOIN product_has_subcategory AS phsc ON phsc.Subcategory_id = sc.id"
                ." WHERE phsc.Product_id = '".$row['id']."'");
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

            // Kijkt welke producten worden aangevinkt aan de hand van het id
            $checkValueProd = $row['id'];
            echo "<br /><input type='checkbox' name='checkboxProd[]' value='$checkValueProd' style='margin-top:5px;' />";
            echo "</div>";
        }
    }

    // Functie die producten verwijdert
    public function deleteProducts($DBconnect) {
    	// Gaat elk aangevinkt product af
        foreach ($_POST['checkboxProd'] as $del_id) {
            $del_id = (int)$del_id;
            // Verwijdert de producten uit de database als de query is geslaagt
            if ($DBconnect->query("DELETE FROM product WHERE id = $del_id")) {
                if ($DBconnect->query("DELETE FROM product_has_subcategory WHERE Product_id = $del_id")) {
                    echo '<script>alert("succes");</script>';
                }
            } else {
                echo '<script>alert("error");</script>';
            }
        }
    }

    // Functie die producten wijzigt
    public function updateProducts($DBconnect) {
        $x = 0;
        // Gaat elk aangevinkt product af
        foreach ($_POST['checkboxProd'] as $up_id) {
            $up_id = (int)$up_id;
            // Gaat de productnamen af
            foreach ($_POST['productName'] as $prodName) {
            	// Hoogt variabele x elke productnaam op
                $x++;
                // Checkt of het product is aangevinkt door het te vergelijken met variabele x
                if ($x == $up_id) {
                	// Wijzigt de productnaam in de database
                    $DBconnect->query("UPDATE product SET product_name = '" . $prodName . "' WHERE id = $up_id");
                }
            }
            $x = 0;
            // Gaat de productprijs af
            foreach ($_POST['productPrice'] as $prodPrice) {
            	// Hoogt variabele x elke productprijs op
            	$x++;
            	// Checkt of het product is aangevinkt door het te vergelijken met variabele x
                if ($x == $up_id) {
                	// Wijzigt de productprijs in de database
                    $DBconnect->query("UPDATE product SET price = " . $prodPrice . " WHERE id = $up_id");
                }
            }
            $x = 0;
            // Gaat de productsbeschrijving af
            foreach ($_POST['productDescription'] as $prodDescription) {
            	// Hoogt variabele x elke productsbeschrijving op
            	$x++;
            	// Checkt of het product is aangevinkt door het te vergelijken met variabele x
                if ($x == $up_id) {
                	// Wijzigt de productsbeschrijving in de database
                    $DBconnect->query("UPDATE product SET description = '" . $prodDescription . "' WHERE id = $up_id");
                }
            }
            $x = 0;
            // Gaat de SubCategorieën af
            foreach ($_POST['productSubCategory'] as $prodSubCategory) {
            	// Hoogt variabele x elke subcategorie op
            	$x++;
            	// Checkt of het product is aangevinkt door het te vergelijken met variabele x
                if ($x == $up_id) {
                    // Bepalen wat de Category_id is aan de hand van de volgende query
                    $subCatNameQuery = $DBconnect->query("SELECT id FROM subcategory"
                        ." WHERE subcategory_name = '".$prodSubCategory."';");
                    $subCatNameRow = $subCatNameQuery->fetch_array();
                    // Wijzigt de Subcategory_id van een product aan de hand van welke subcategorie wordt geselecteerd
                    $DBconnect->query("UPDATE product_has_subcategory SET Subcategory_id = " . $subCatNameRow['id'] . " WHERE Product_id = $up_id");
                }
            }
        }
    }

    // Functie die Categorieën laat zien
    public function viewCategorys($DBconnect) {
		// Haalt alle Categorieën uit de database op
        $query = "SELECT * FROM category ORDER BY id";
        $result = mysqli_query($DBconnect, $query);

        echo "<form method='post'>";
        
        // Gaat elke categorie af
        while ($row = mysqli_fetch_array($result)) {
        	// Vult de Categorieën met gegevens uit de database
            echo "<li><input required type='text' name='catName[]' value='" . $row['category_name'] . "'</li>";
            $checkValueCat = $row['id'];
            echo "<input type='checkbox' name='checkboxCat[]' value='$checkValueCat' style='margin-top:5px;' />";

            // Haalt alle SubCategorieën op aan de hand van de Category_id
            $subquery = "SELECT * FROM subcategory where Category_id = " . $row['id']." ORDER BY id";
            $subresult = mysqli_query($DBconnect, $subquery);

            // Gaat elke subcategorie af
            while ($row = mysqli_fetch_array($subresult)) {
            	// Vult de SubCategorieën met gegevens uit de database
                echo "<li style='margin-left:10%'><input required type='text' name='subCatName[]' value='" . $row['subcategory_name'] . "' </li>";
                $checkValue = $row['id'];
                echo "<input type='checkbox' name='checkbox[]' value='$checkValue' style='margin-top:5px;' />";
            }
        }
        // De buttons voor het updaten en verwijderen van Categorieën
        echo "<br /><input type='submit' name='updateCategory' style='margin-top:5px;' class='btn btn-warning' value='Update category' />&nbsp;";
        echo "<input type='submit' name='deleteCategory' style='margin-top:5px;' class='btn btn-danger' value='Delete category' /><br />";

        echo "<input type='submit' name='updateSubCategory' style='margin-top:5px;' class='btn btn-warning' value='Update subcategory' />&nbsp;";
        echo "<input type='submit' name='deleteSubCategory' style='margin-top:5px;' class='btn btn-danger' value='Delete subcategory' />";

        echo "</form><br />";
    }

    // Functie die Categorieën verwijdert
    public function deleteCategorys($DBconnect) {
    	// Gaat alle Categorieën af die zijn aangevinkt
        foreach ($_POST['checkboxCat'] as $del_id) {
            $del_id = (int)$del_id;
            // Als de query slaagt dan wordt er een aangevinkte categorie met daarbijbehorende SubCategorieën verwijdert
            if ($DBconnect->query("DELETE FROM category WHERE id = $del_id") && $DBconnect->query("DELETE FROM subcategory WHERE Category_id = $del_id")) {
                echo '<script>alert("succes");</script>';
            } else {
                echo '<script>alert("error");</script>';
            }
        }
    }

    // Functie die SubCategorieën verwijdert
    public function deleteSubCategorys($DBconnect) {
    	// Gaat alle SubCategorieën af die zijn aangevinkt
        foreach ($_POST['checkbox'] as $del_id) {
            $del_id = (int)$del_id;
            // Als de query slaagt dan wordt er een aangevinkte subcategorie verwijdert
            if ($DBconnect->query("DELETE FROM subcategory WHERE id = $del_id")) {
                echo '<script>alert("succes");</script>';
            } else {
                echo '<script>alert("error");</script>';
            }
        }
    }

    // Functie die Categorieën wijzigt
    public function updateCategorys($DBconnect) {
    	// Gaat alle Categorieën af die zijn aangevinkt
        foreach ($_POST['checkboxCat'] as $up_id) {
            $up_id = (int)$up_id;
            // Als de query slaagt dan wordt er voor elke aangevinkte categorie de categorienaam gewijzigt
            foreach ($_POST['catName'] as $catName) {
                $DBconnect->query("UPDATE category SET category_name = '" . $catName . "' WHERE id = $up_id");
            }

        }
    }

    // Functie die SubCategorieën wijzigt
    public function updateSubCategorys($DBconnect) {
        $x = 0;
    	// Gaat alle SubCategorieën af die zijn aangevinkt
        foreach ($_POST['checkbox'] as $up_id) {
            $up_id = (int)$up_id;
            // Als de query slaagt dan wordt er voor elke aangevinkte subcategorie de subcategorienaam gewijzigt

            foreach ($_POST['subCatName'] as $subCatName) {
                if ($x == $up_id) {
                    $DBconnect->query("UPDATE subcategory SET subcategory_name = '" . $subCatName . "' WHERE id = $up_id");
                    echo '<script>alert("'.$x.'");</script>';
                }
            }
        }
    }

    // Functie die Orders laat zien
    public function viewOrders($DBconnect) {
    	// Haalt alle orders uit de database op
        $query = "SELECT * FROM `order`";
        $result = mysqli_query($DBconnect, $query);

        // Gaat elke order af
        while ($row = mysqli_fetch_array($result)) {
        	// Vult de order met gegevens uit de database
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

    // Functie die Orders verwijdert
    public function deleteOrders($DBconnect) {
    	// Gaat alle orders af die zijn aangevinkt
        foreach ($_POST['checkbox'] as $del_id) {
            $del_id = (int)$del_id;
            // Aangevinkte orders worden verwijdert in de database
            $query = $DBconnect->query("DELETE FROM `order` WHERE id = $del_id");
        }
    }

    // Functie die een dropdown vult van SubCategorieën
    public function getDropdown($connect) {
        // Het ophalen van de subcategorie;
        $subCatQuery = ("SELECT * FROM subcategory;");
        $subCatResult = mysqli_query($connect, $subCatQuery);
        $select = "<p>Subcategorie: <select name='product_SubCatName' style='width: 174px;'>";
        // Loopt door alle rows van subcategory
        while ($row = mysqli_fetch_array($subCatResult))
        {
            $select.= "<option value='".$row['subcategory_name']."'>".$row['subcategory_name']."</option>";
        }
        $select.= "</select></p>";

        return $select;
    }
    
    // Functie die een dropdown vult van Categorieën
    public function getCategoryDropdown($connect) {
    	// Het ophalen van de subcategorie;
    	$catQuery = ("SELECT * FROM category;");
    	$catResult = mysqli_query($connect, $catQuery);
    	$select = "<p>Categorie: <select name='product_CatName' style='width: 174px;'>";
    	// Loopt door alle rows van subcategory
    	while ($row = mysqli_fetch_array($catResult))
    	{
    		$select.= "<option value='".$row['category_name']."'>".$row['category_name']."</option>";
    	}
    	$select.= "</select></p>";
    	
    	return $select;
    }

    // Functie die een Product toevoegt
    public function addProduct($connect) {
    	// Het ophalen en toevoegen van een afbeelding
        $target = "images/posters/".basename($_FILES['image']['name']);
        $image = $_FILES['image']['name'];

        // Voegt producten toe aan de database aan de hand van ingevoerde gegevens
        $query = $connect->query("INSERT INTO product (product_name,price,description,image) VALUES ('".$_POST['product_name']."','".$_POST['product_price']."','".$_POST['product_beschrijving']."','$image');");
        $last_id = $connect->insert_id;

        // Checkt of product_SubCatName niet null is
        if ($_POST["product_SubCatName"] != null)
        {
            // Het toevoegen van de subcategorie naam aan de variabele $selectedValue
            $selectedValue = $_POST['product_SubCatName'];
            // We selecteren het id dat bij de meegegeven subcategorienaam hoort
            $subCatNameQuery = $connect->query("SELECT id FROM subcategory"
                ." WHERE subcategory_name = '".$selectedValue."';");
            $subCatNameRow = $subCatNameQuery->fetch_array();

            // Voegt de producten toe aan een subcategorie aan de hand van de geselecteerde subcategorie
            $queryAddSubCat = $connect->query("INSERT INTO product_has_subcategory (Product_id, Subcategory_id) VALUES ('".$last_id."', '".$subCatNameRow['id']."');");
        }

        // Verandert de locatie van de file naar de target als alles goed gaat
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            echo '<script>window.location="admin.php"</script>';
        }
        else {
            echo "<script>alert('Error');</script>";
        }
    }

    // Functie die ene Categorie toevoegt
    public function addCategoryItem($connect) {
    	// Voegt een categorie toe aan de hand van een ingevoerde categorienaam
        $query = $connect->query("INSERT INTO category (category_name) VALUES ('".$_POST['category_name']."');");
    }

    // Functie die ene SubCategorie toevoegt
    public function addSubCategoryItem($connect) {
    	// Haalt het id van een categorie op aan de hand van de categorienaam
    	$catIdQuery = $connect->query("SELECT id FROM category where category_name = '".$_POST['product_CatName']."'");
    	$catIdRow = $catIdQuery->fetch_array();
    	// Voegt een subcategorie toe aan de hand van een ingevoerde subcategorienaam en geselecteerde categorie
        $query = $connect->query("INSERT INTO subcategory (subcategory_name,Category_id) VALUES ('".$_POST['subcategory_name']."','".$catIdRow['id']."');");
    }
}

?>