<?php
session_start();
$connect = mysqli_connect("localhost", "root", "", "posterhouse_databaseV5");

if (isset($_SESSION['userSession'])) {
    $query = $connect->query("SELECT * FROM user WHERE user_id=".$_SESSION['userSession']);
    $userRow=$query->fetch_array();
}

// Het ophalen van de subcategorie;
$subCatQuery = ("SELECT * FROM subcategory");
$subCatResult = mysqli_query($connect, $subCatQuery);
$select = "<p>Subcategorie: <select name='product_SubCatName' style='width: 174px;'>";
// Loopt door alle rows van subcategory
while ($row = mysqli_fetch_array($subCatResult))
{
	$select.= "<option value='".$row['subcategory_name']."'>".$row['subcategory_name']."</option>";
}
$select.= "</select></p>";

if (isset($_POST['upload'])) {
    $target = "images/posters/".basename($_FILES['image']['name']);
    $image = $_FILES['image']['name'];

    $query = $connect->query("INSERT INTO product (product_name,price,description,image) VALUES ('".$_POST['product_name']."','".$_POST['product_price']."','".$_POST['product_beschrijving']."','$image');");
    $last_id = $connect->insert_id;
    
    // Checkt of product_SubCatName niet null is
    if ($_POST["product_SubCatName"] != null)
    {
    	// Het toevoegen van de subcategorie naam aan de variabele $selectedValue
    	$selectedValue = $_POST['product_SubCatName'];
    	// Bepalen wat de Category_id is aan de hand van de volgende query
    	$catNameQuery = $connect->query("SELECT * FROM subcategory AS sc"
    									." JOIN category AS c ON c.id = sc.Category_id"
    									." JOIN product_has_category AS phc ON phc.Category_id = c.id"
    									." WHERE sc.subcategory_name = '".$selectedValue."'");
    	$catNameRow = $catNameQuery->fetch_array();
   
    	$queryAddSubCat = $connect->query("INSERT INTO product_has_category (Product_id, Category_id) VALUES ($last_id,'".$catNameRow['Category_id']."');");
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
                <?php echo $select; ?>
            </div>
            <div>
                <input type="submit" name="upload" class="btn btn-success" value="Add new product">
            </div>
        </form>
    </div>
</div>
</body>
</html>