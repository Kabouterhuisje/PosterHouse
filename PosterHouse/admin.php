<?php
// We starten de sessie en includen de database connectie en de Admin klasse
session_start();
include 'dbconnect.php';
include 'ClAdmin.php';

// Checkt of de usersessie is gezet
if (isset($_SESSION['userSession'])) {
    $query = $DBconnect->query("SELECT * FROM user WHERE user_id=".$_SESSION['userSession']);
    $userRow=$query->fetch_array();
}

// Checkt of de gebruiker zijn rol 'Admin' is
if ($userRow['role'] == 'Admin'){
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Verwijzingen -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body style="padding-bottom: 167px;">
<?php
require 'header.php';
?>
<div class="container"><br/><br/><br/><br/>

	<!-- Navigatiemenu van het admin panel -->
    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#home">Home</a></li>
        <li><a data-toggle="tab" href="#menu1">Producten</a></li>
        <li><a data-toggle="tab" href="#menu2">Categoriën</a></li>
        <li><a data-toggle="tab" href="#menu3">Bestellingen</a></li>
    </ul>

    <div class="tab-content">
    	<!-- Welkomsscherm -->
        <div id="home" class="tab-pane fade in active"><br/>
            <div class="jumbotron">
                <h1>Welkom, administrator!</h1>
                <p>U bevind zich op het admin panel. Beheer makkelijk de webshop door dingen toe te voegen, verwijderen
                    of wijzigen. Klik op een tab om aan de slag te gaan!</p>
            </div>
        </div>
        <!-- Producten -->
        <div id="menu1" class="tab-pane fade">
            <div class="col-sm-6" style="margin-bottom:2%; text-align:center;">
                <form method='post' style='margin-right: -400px'>
                    <h2>Producten 
                    	<!-- Voegt de toevoeg, wijzig en verwijder button toe -->
                    	<input type='submit' name='addProduct' style='margin-top:5px;' class='btn btn-success'
                                         value='Add'/>
                        <input type='submit' name='updateProduct' style='margin-top:5px;' class='btn btn-warning'
                               value='Update'/>
                        <input type='submit' name='deleteProduct' style='margin-top:5px;' class='btn btn-danger'
                               value='Delete'/>
                    </h2>

                    <?php
				
                    $admin = new Admin();
                    // Roept de viewProducts functie aan
                    $admin->viewProducts($DBconnect);

                    ?>
                </form>
                <?php
                // Checkt of je een product wilt toevoegen
                if (isset($_POST['addProduct'])) {
                    echo '<script>window.location="addProduct.php"</script>';
                }

                // Checkt of je een product wilt verwijderen en checkt of het product is aangevinkt
                if (isset($_POST['deleteProduct']) && isset($_POST['checkboxProd'])) {
                	// Roept de deleteProducts functie aan
                    $admin->deleteProducts($DBconnect);
                    // Stuurt je terug naar het admin homescherm
                    echo '<script>window.location="admin.php"</script>';
                }

                // Checkt of je een product wilt wijzigen en checkt of het product is aangevinkt
                if (isset($_POST['updateProduct']) && isset($_POST['checkboxProd'])) {
                	// Roept de updateProducts functie aan
                    $admin->updateProducts($DBconnect);
                    // Stuurt je terug naar het admin homescherm
                    echo '<script>window.location="admin.php"</script>';
                }
                ?>
            </div>
        </div>
        <!-- Categorieën -->
        <div id="menu2" class="tab-pane fade"><br/>
            <form method="post" action="addCategory.php">
                <h2>Categorieën 
                	<!-- Voegt de toevoeg button toe -->
                	<input type='submit' name='addCategory' style='margin-top:5px;' class='btn btn-success' value='Add'/>
                </h2>
            </form>
            <?php
            // Roept de viewCategorys functie aan
            $admin->viewCategorys($DBconnect);

            	// Controleert of je een categorie wilt verwijderen en checkt of de categorie is aangevinkt
                if (isset($_POST['deleteCategory']) && isset($_POST['checkboxCat'])) {
                	// Roept de deleteCategorys functie aan
                    $admin->deleteCategorys($DBconnect);
                    // Stuurt je terug naar het admin homescherm
                    echo '<script>window.location="admin.php"</script>';
                }
                // Controleert of je een subcategorie wilt verwijderen en checkt of de subcategorie is aangevinkt
                if (isset($_POST['deleteSubCategory']) && isset($_POST['checkbox'])) {
                	// Roept de deleteSubCategorys functie aan
                    $admin->deleteSubCategorys($DBconnect);
                    // Stuurt je terug naar het admin homescherm
                    echo '<script>window.location="admin.php"</script>';
                }
                // Controleert of je een categorie wilt wijzigen en checkt of de categorie is aangevinkt
                if (isset($_POST['updateCategory']) && isset($_POST['checkboxCat'])) {
                	// Roept de updateCategorys functie aan
                    $admin->updateCategorys($DBconnect);
                    // Stuurt je terug naar het admin homescherm
                    echo '<script>window.location="admin.php"</script>';
                }
                // Controleert of je een subcategorie wilt wijzigen en checkt of de subcategorie is aangevinkt
                if (isset($_POST['updateSubCategory']) && isset($_POST['checkbox'])) {
                	// Roept de updateSubCategorys functie aan
                    $admin->updateSubCategorys($DBconnect);
                    // Stuurt je terug naar het admin homescherm
                    echo '<script>window.location="admin.php"</script>';
                }
            ?>
        </div>
        <!-- Bestellingen -->
        <div id="menu3" class="tab-pane fade"><br/>
            <div class="col-sm-12" style="margin-bottom:2%; text-align:center;">
                <form method='post'>
                <h2>Bestellingen <input type='submit' name='deleteOrder' style='margin-top:5px;' class='btn btn-danger' value='Delete' /></h2>

                <?php

                // Roept de viewOrders functie aan
                $admin->viewOrders($DBconnect);

                // Controleert of je een order wilt deleten
                if (isset($_POST['deleteOrder'])) {
                	// Roept de deleteOrders functie aan
                    $admin->deleteOrders($DBconnect);
                    // Stuurt je terug naar het admin homescherm
                    echo '<script>window.location="admin.php"</script>';
                }

                // Sluit de databaseconnectie
                $DBconnect->close();
                ?>
            </div>
        </div>
    </div>
</div>
<?php
}
// Als je geen admin bent wordt je naar de login pagina verwezen
else {
    echo '<script>window.location="login.php"</script>';
}
require 'footer.php';
?>
</body>
</html>