<?php
class Producten {
	// Functie voor de Categorieën
    public function viewCategoryMenu($DBconnect) {
    	// Vraagt alle Categorieën op uit de database
        $query = "SELECT * FROM category";
        $result = mysqli_query($DBconnect, $query);

        // Gaat elke categorie af
        while($row = mysqli_fetch_array($result))
        {
        	// Filtert de producten op de categorie die je selecteert
            echo "<form action='producten.php' method='get'>";
            echo "<li><a href='producten.php?category=".$row['category_name']."'><p>".$row['category_name']."</p></a></li>";
            echo "</form>";

            // Vraagt alle Subcategorieën op uit de database
            $subquery = "SELECT * FROM subcategory where Category_id = ".$row['id'];
            $subresult = mysqli_query($DBconnect, $subquery);
            $num_rows = mysqli_num_rows($result);

            // Controleert of er rows worden gevonden
            if($num_rows > 0)
            {
            	// Gaat elke subcategorie af
                while($row = mysqli_fetch_array($subresult))
                {
                	// Filtert de producten op de subcategorie die je selecteert
                    echo "<form action='producten.php' method='get'>";
                    echo "<li style='margin-left:10%'><a href='producten.php?subcategory=".$row['subcategory_name']."'><p>".$row['subcategory_name']."</p></a></li>";
                    echo "</form>";
                }
            }
        }
    }

    // Functie voor het laten zien van de producten
    public function viewProducts($DBconnect) {
        // Controleert of er wordt gezocht
        if (isset($_GET['btnsearch']))
        {
        	// Haalt producten op aan de hand van het ingegeven zoekwoord
            $query = "SELECT * FROM product WHERE product_name LIKE '%" . $_GET['searchbar'] . "%'";
        }
        // Controleert of iemand filtert op een categorie
        else if (isset($_GET['category']))
        {
        	// Haalt producten op aan de hand van de aangeklikte categorie
            $query = "SELECT * FROM product JOIN product_has_category ON product_has_category.Product_id = product.id"
                ." JOIN category ON category.id = product_has_category.Category_id where category_name = '" . $_GET['category'] . "'";
        }
        // Controleert of iemand filtert op een subcategorie
        else if (isset($_GET['subcategory']))
        {
        	// Haalt producten op aan de hand van de aangeklikte subcategorie
            $query = "SELECT * FROM product JOIN product_has_category ON product_has_category.Product_id = product.id"
                ." JOIN category ON category.id = product_has_category.Category_id JOIN subcategory ON subcategory.Category_id = category.id"
                ." where subcategory_name = '" . $_GET['subcategory'] . "'";
        }
        // Zoniet dat laten we alle producten zien
        else
        {
            $query = "SELECT * FROM product";
        }
        $result = mysqli_query($DBconnect, $query);
        $num_rows = mysqli_num_rows($result);

        // De hoeveelheid resultaten die we per pagina willen laten zien
        $countresults = 8;
        // Maakt de variabele global zodat deze overal gebruikt kan worden
        global $countpages;
        // De hoeveelheid pagina's die we nodig hebben
        $countpages = ceil($num_rows / $countresults);

        // Het bepalen op welke pagina de gebruiker zit
        if(!isset($_GET['page']))
        {
            $page = 1;
        }
        else
        {
            $page = $_GET['page'];
        }

        // Het bepalen van het sql LIMIT startcijfer
        $firstresult = ($page - 1) * $countresults;

        // Het ophalen van de geselecteerde resultaten uit de database
        if (isset($_GET['btnsearch']))
        {
        	// Haalt producten op aan de hand van het ingegeven zoekwoord en voegt er een limit aan toe
            $query = "SELECT * FROM product WHERE product_name LIKE '%" . $_GET['searchbar'] . "%' LIMIT " . $firstresult . ',' . $countresults;
        }
        else if (isset($_GET['category']))
        {
        	// Haalt producten op aan de hand van de aangeklikte categorie en voegt er een limit aan toe
            $query = "SELECT * FROM `product` JOIN product_has_category ON product_has_category.Product_id = product.id"
                ." JOIN category ON category.id = product_has_category.Category_id where category_name = '" . $_GET['category'] . "'"
                ." LIMIT " . $firstresult . ',' . $countresults;
        }
        else if (isset($_GET['subcategory']))
        {
        	// Haalt producten op aan de hand van de aangeklikte subcategorie en voegt er een limit aan toe
            $query = "SELECT * FROM product JOIN product_has_category ON product_has_category.Product_id = product.id"
                ." JOIN category ON category.id = product_has_category.Category_id JOIN subcategory ON subcategory.Category_id = category.id"
                ." where subcategory_name = '" . $_GET['subcategory'] . "'"
                ." LIMIT " . $firstresult . ',' . $countresults;
        }
        // Zoniet dan selecteren we alle producten met het toegevoegde limit
        else
        {
            $query = "SELECT * FROM product LIMIT " . $firstresult . ',' . $countresults;
        }
        $result = mysqli_query($DBconnect, $query);

        // Checkt of er meer dan 0 rows worden opgehaald
        if($num_rows > 0)
        {
        	// We loopen door alle rows
            for ($i = 0; $i < $num_rows; $i++)
            {
            	// Door de limit laat 1 pagina maar 8 producten zien
                while($row = mysqli_fetch_array($result))
                {
                	// Laat de (gefilterde) producten zien
                    echo "<form method='post' action='winkelmandje.php?action=add&id=".$row["id"]."'>";
                    echo "<div class='col-xs-6 col-md-3' align='center'>";
                    echo "<img src='images/posters/".$row['image']."' height='250' width='180'/>";
                    echo "<p> €".$row['price']."</p>";
                    echo "<a href='productdetails.php?id=".$row['id']."'>".$row['product_name']."</a>";
                    echo "</div>";
                    echo "</form>";
                }
            }
        }
    }

    // Functie voor de pagination
    public function viewPagination() {
        // Kijkt hoeveel pages er gemaakt moeten worden
        for ($page=1; $page<=$GLOBALS['countpages']; $page++)
        {
        	// Weergeeft de pagina nummers die je doorsturen naar het aangeklikte paginanummer
            echo '<li><a href="producten.php?page=' . $page . '">' . $page . '</a></li>';
        }
    }
}

?>