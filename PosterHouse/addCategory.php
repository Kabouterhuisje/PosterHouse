<?php
session_start();
$connect = mysqli_connect("localhost", "root", "", "posterhouse_databaseV4");

if (isset($_SESSION['userSession'])) {
    $query = $connect->query("SELECT * FROM user WHERE user_id=".$_SESSION['userSession']);
    $userRow=$query->fetch_array();
}

if (isset($_POST['addCat'])) {
    $query = $connect->query("INSERT INTO category (category_name) VALUES ('".$_POST['category_name']."');");
}

if (isset($_POST['addSubCat'])) {
    $query = $connect->query("INSERT INTO subcategory (subcategory_name,Category_id) VALUES ('".$_POST['subcategory_name']."',".$_POST['category_id'].");");
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Categorie toevoegen</title>
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
            <div>
                Categorienaam: <input type="text" name="category_name">
            </div>
            <div>
                <input type="submit" name="addCat" class="btn btn-success" value="Add new category">
            </div>
        </form>
    </div>

    <div id="content">
        <form method="post" enctype="multipart/form-data">
            <div>
                Subcategorienaam: <input type="text" name="subcategory_name">
            </div>
            <div>
                Categorie ID: <input type="number" name="category_id">
            </div>
            <div>
                <input type="submit" name="addSubCat" class="btn btn-success" value="Add new subcategory">
            </div>
        </form>
    </div>

</div>
</body>
</html>