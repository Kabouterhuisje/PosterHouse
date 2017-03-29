<?php
// We starten de sessie en includen de database connectie en de Admin klasse
session_start();
include 'dbconnect.php';
include 'ClAdmin.php';

// Checkt of de usersessie is gezet
if (isset($_SESSION['userSession'])) {
    $query = $connect->query("SELECT * FROM user WHERE user_id=".$_SESSION['userSession']);
    $userRow=$query->fetch_array();
}

$admin = new Admin();

// Kijkt of upload is gepost en roept vervolgens functie addProduct aan
if (isset($_POST['upload'])) {
    $admin->addProduct($connect);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Product toevoegen</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Verwijzingen -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!-- Styling -->
    <style>
        #content{
            width: 50%;
            margin: 20px auto;
            margin-top: 60px;
            border: 1px solid #cbcbcb;
        }
        form{
            width: 50%;
            margin: 20px auto;
        }
        form div{
            margin-top: 5px;
        }
    </style>
</head>
<body style="padding-bottom: 167px;">

<div class="container"><br /><br /><br /><br />
    <form method="post" action="admin.php">
        <input type='submit' name='goBack' style='margin-top:5px;' class='btn btn-primary' value='Go Back' />
    </form>
    <!-- Product toevoegen -->
    <div id="content">
        <form method="post" enctype="multipart/form-data">
            <input type="hidden" name="size" value="1000000">
            <div>
                <input type="file" name="image">
            </div>
            <div>
                Productnaam: <input type="text" name="product_name">
            </div>
            <div>
                Prijs in euro: <input type="number" step="any" name="product_price">
            </div>
            <div>
                Beschrijving: <input type="text" name="product_beschrijving">
            </div>
            <div>
            	<!-- Roept de getDropdown functie aan -->
                <?php echo $admin->getDropdown($connect); ?>
            </div>
            <div>
                <input type="submit" name="upload" class="btn btn-success" value="Add new product">
            </div>
        </form>
    </div>
</div>
</body>
</html>