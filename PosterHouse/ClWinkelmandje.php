<?php

class ShoppingCart {

    public function addToCard() {

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

    public function deleteFromCard() {

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

    public function checkout($connect) {
        $total = 0;
        foreach($_SESSION["shopping_cart"] as $keys => $values)
        {
            $total = $total + ($values["item_quantity"] * $values["item_price"]);
        }

        if(isset($_SESSION['userSession'])) {

            $query = "INSERT INTO `order` (total_price,date_created,User_id) VALUES ($total,CURRENT_DATE,".$_SESSION['userSession'].")";

            if ($connect->query($query)) {
                $last_id = $connect->insert_id;
                $locationPage = "";
                if (isset($_SESSION['userSession'])) {
                    $locationPage = "order_overview.php";
                    echo '<script>window.location="order_overview.php"</script>';
                }
                else {
                    $locationPage = "login.php";
                }

            }else {
                echo '<script>alert("error");</script>';
            }

            foreach($_SESSION["shopping_cart"] as $keys => $values)
            {
                $details = "INSERT INTO order_has_product (Order_id,Order_User_id,quantity,Product_id) VALUES (".$last_id.",".$_SESSION['userSession'].",".$_POST['quantity'].",".$values['item_id'].")";
                $connect->query($details);
            }
        }
        else {
            echo '<script>window.location="login.php"</script>';
        }
    }

    public function closeOverview() {
        unset($_SESSION['shopping_cart']);
    }

    public function viewShoppingCart($connect) {
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
            </tr>
            <?php
        }
        $connect->close();
    }
}

?>