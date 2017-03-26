<?php

class Producten {

    public function viewCategoryMenu($DBconnect) {
        $query = "SELECT * FROM category";
        $result = mysqli_query($DBconnect, $query);

        while($row = mysqli_fetch_array($result))
        {
            echo "<form action='producten.php' method='get'>";
            echo "<li><a href='producten.php?category=".$row['category_name']."'><p>".$row['category_name']."</p></a></li>";
            echo "</form>";

            $subquery = "SELECT * FROM subcategory where Category_id = ".$row['id'];
            $subresult = mysqli_query($DBconnect, $subquery);
            $num_rows = mysqli_num_rows($result);

            if($num_rows > 0)
            {
                while($row = mysqli_fetch_array($subresult))
                {
                    echo "<form action='producten.php' method='get'>";
                    echo "<li style='margin-left:10%'><a href='producten.php?subcategory=".$row['subcategory_name']."'><p>".$row['subcategory_name']."</p></a></li>";
                    echo "</form>";
                }
            }
        }
    }

    public function viewProducts($DBconnect) {
        // Kijken of er een request uit btnsearch komt
        if (isset($_GET['btnsearch']))
        {
            $query = "SELECT * FROM product WHERE product_name LIKE '%" . $_GET['searchbar'] . "%'";
        }
        else if (isset($_GET['category']))
        {
            $query = "SELECT * FROM product JOIN product_has_category ON product_has_category.Product_id = product.id"
                ." JOIN category ON category.id = product_has_category.Category_id where category_name = '" . $_GET['category'] . "'";

        }
        else if (isset($_GET['subcategory']))
        {
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
            $query = "SELECT * FROM product WHERE product_name LIKE '%" . $_GET['searchbar'] . "%' LIMIT " . $firstresult . ',' . $countresults;
        }
        else if (isset($_GET['category']))
        {
            $query = "SELECT * FROM `product` JOIN product_has_category ON product_has_category.Product_id = product.id"
                ." JOIN category ON category.id = product_has_category.Category_id where category_name = '" . $_GET['category'] . "'"
                ." LIMIT " . $firstresult . ',' . $countresults;
        }
        else if (isset($_GET['subcategory']))
        {
            $query = "SELECT * FROM product JOIN product_has_category ON product_has_category.Product_id = product.id"
                ." JOIN category ON category.id = product_has_category.Category_id JOIN subcategory ON subcategory.Category_id = category.id"
                ." where subcategory_name = '" . $_GET['subcategory'] . "'"
                ." LIMIT " . $firstresult . ',' . $countresults;
        }
        else
        {
            $query = "SELECT * FROM product LIMIT " . $firstresult . ',' . $countresults;
        }
        $result = mysqli_query($DBconnect, $query);

        if($num_rows > 0)
        {
            for ($i = 0; $i < $num_rows; $i++)
            {
                while($row = mysqli_fetch_array($result))
                {
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

    public function viewPagination() {
        // Het weergeven van de links naar de pagina's
        for ($page=1; $page<=$GLOBALS['countpages']; $page++)
        {
                echo '<li><a href="producten.php?page=' . $page . '">' . $page . '</a></li>';
        }
    }
}

?>