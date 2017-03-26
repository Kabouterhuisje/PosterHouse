<?php
session_start();
include 'dbconnect.php';
include 'ClAdmin.php';

if (isset($_SESSION['userSession'])) {
    $query = $DBconnect->query("SELECT * FROM user WHERE user_id=".$_SESSION['userSession']);
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

                    $admin = new Admin();
                    $admin->viewProducts($DBconnect);

                    ?>
                </form>
                <?php

                if (isset($_POST['addProduct'])) {
                    echo '<script>window.location="addProduct.php"</script>';
                }

                if (isset($_POST['deleteProduct']) && isset($_POST['checkboxProd'])) {
                    $admin->deleteProducts($DBconnect);
                    echo '<script>window.location="admin.php"</script>';
                }

                if (isset($_POST['updateProduct']) && isset($_POST['checkboxProd'])) {
                    $admin->updateProducts($DBconnect);
                    echo '<script>window.location="admin.php"</script>';
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

            $admin->viewCategorys($DBconnect);

                if (isset($_POST['deleteCategory']) && isset($_POST['checkboxCat'])) {
                    $admin->deleteCategorys($DBconnect);
                    echo '<script>window.location="admin.php"</script>';
                }

                if (isset($_POST['deleteSubCategory']) && isset($_POST['checkbox'])) {
                    $admin->deleteSubCategorys($DBconnect);
                    echo '<script>window.location="admin.php"</script>';
                }

                if (isset($_POST['updateCategory']) && isset($_POST['checkboxCat'])) {
                    $admin->updateCategorys($DBconnect);
                    echo '<script>window.location="admin.php"</script>';
                }

                if (isset($_POST['updateSubCategory']) && isset($_POST['checkbox'])) {
                    $admin->updateSubCategorys($DBconnect);
                    echo '<script>window.location="admin.php"</script>';
                }

            ?>
        </div>
        <div id="menu3" class="tab-pane fade"><br/>
            <div class="col-sm-12" style="margin-bottom:2%; text-align:center;">
                <form method='post'>
                <h2>Bestellingen <input type='submit' name='deleteOrder' style='margin-top:5px;' class='btn btn-danger' value='Delete' /></h2>

                <?php

                $admin->viewOrders($DBconnect);

                if (isset($_POST['deleteOrder'])) {
                    $admin->deleteOrders($DBconnect);
                    echo '<script>window.location="admin.php"</script>';
                }

                $DBconnect->close();
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