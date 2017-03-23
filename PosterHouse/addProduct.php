<?php
session_start();
$connect = mysqli_connect("localhost", "root", "", "posterhouse_databaseV5");

if (isset($_SESSION['userSession'])) {
    $query = $connect->query("SELECT * FROM user WHERE user_id=".$_SESSION['userSession']);
    $userRow=$query->fetch_array();
}

if (isset($_POST['upload'])) {
    $target = "images/posters/".basename($_FILES['image']['name']);
    $image = $_FILES['image']['name'];

    $query = $connect->query("INSERT INTO product (product_name,price,description,image) VALUES ('".$_POST['product_name']."','".$_POST['product_price']."','".$_POST['product_beschrijving']."','$image');");
    $last_id = $connect->insert_id;
    $queryAddCat = $connect->query("INSERT INTO product_has_category (Product_id, Category_id) VALUES ($last_id,'".$_POST['product_CatID']."');");
    if ($_POST['product_SubCatName'] != null && $_POST['product_SubCatID'] != null) {
        $queryAddSubCat = $connect->query("INSERT INTO subcategory (subcategory_name,Category_id) VALUES ('".$_POST['product_SubCatName']."','".$_POST['product_SubCatID']."');");
    }

    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        echo '<script>window.location="admin.php"</script>';
    }
    else {
        echo "<script>alert('Error');</script>";
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Product toevoegen</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
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
                Categorie ID: <input type="number" name="product_CatID">
            </div>
            <div>
                Subcategorienaam: <input type="text" name="product_SubCatName">
            </div>
            <div>
                Categorie ID: <input type="number" name="product_SubCatID">
            </div>
            <div>
                <input type="submit" name="upload" class="btn btn-success" value="Add new product">
            </div>
        </form>
    </div>
</div>
</body>
</html>