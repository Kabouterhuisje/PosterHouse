<?php
session_start();
$connect = mysqli_connect("localhost", "root", "", "posterhouse_database");

if (isset($_SESSION['userSession'])) {
    $query = $connect->query("SELECT * FROM user WHERE user_id=".$_SESSION['userSession']);
    $userRow=$query->fetch_array();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo $userRow['username'];?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<?php
require 'header.php';
?>

<?php

    $uName;
    $uTel;
    $uAddress;
    $uCity;
    $uCountry;

    if (empty($userRow['name'])) {
        $uName = 'Naam';
    }
    else {
        $uName = $userRow['name'];
    }

    if (empty($userRow['phone'])) {
        $uTel = '0612345678';
    }
    else {
        $uTel = $userRow['phone'];
    }

    if (empty($userRow['address'])) {
        $uAddress = 'Adres';
    }
    else {
        $uAddress = $userRow['address'];
    }

    if (empty($userRow['city'])) {
        $uCity = 'Stad';
    }
    else {
        $uCity = $userRow['city'];
    }

    if (empty($userRow['country'])) {
        $uCountry = 'Land';
    }
    else {
        $uCountry = $userRow['country'];
    }

?>

<div class="container"><br /><br /><br />
    <h2>Profiel Settings</h2>
    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#home">Home</a></li>
        <li><a data-toggle="tab" href="#menu1">Gegevens</a></li>
        <li><a data-toggle="tab" href="#menu2">Wachtwoord veranderen</a></li>
    </ul>
    <div class="tab-content">
        <div id="home" class="tab-pane fade in active">
            <h3>Home</h3>
            <p>Welkom, <?php echo $userRow['username'];?>!<br /><br /> Pas op deze pagina je gegevens aan om zo eenvoudig producten te kunnen bestellen. De gegevens die u hier invuld, zullen automatisch worden ingevuld als u een product wilt kopen! Bespaar tijd en sla uw contactgegevens nu op in het profiel!</p>
        </div>
        <div id="menu1" class="tab-pane fade">
            <h3>Gegevens</h3>
            <form name="gegevens" method="post" action="">
                <div class="form-group row">
                    <label for="example-text-input" class="col-2 col-form-label">Username</label>
                    <div class="col-10">
                        <input name="username" class="form-control" type="text" value=<?php echo $userRow['username']?> id="example-text-input">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="example-search-input" class="col-2 col-form-label">Email</label>
                    <div class="col-10">
                        <input name="email" class="form-control" type="email" value=<?php echo $userRow['email']?> id="example-search-input">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="example-email-input" class="col-2 col-form-label">Naam</label>
                    <div class="col-10">
                        <input name="name" class="form-control" type="text" value=<?php echo $uName?> id="example-email-input">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="example-url-input" class="col-2 col-form-label">Telefoonnummer</label>
                    <div class="col-10">
                        <input name="phone" class="form-control" type="tel" value=<?php echo $uTel?> id="example-url-input">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="example-tel-input" class="col-2 col-form-label">Adres</label>
                    <div class="col-10">
                        <input name="address" class="form-control" type="text" value=<?php echo $uAddress?> id="example-tel-input">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="example-password-input" class="col-2 col-form-label">Stad</label>
                    <div class="col-10">
                        <input name="city" class="form-control" type="text" value=<?php echo $uCity?> id="example-password-input">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="example-number-input" class="col-2 col-form-label">Land</label>
                    <div class="col-10">
                        <input name="country" class="form-control" type="text" value=<?php echo $uCountry?> id="example-number-input">
                    </div>
                </div>
                <input type="submit" class="btn btn-primary" name="btnInfo" value="Update"></input>
            </form>

            <?php
            if (ISSET($_POST['btnInfo'])) {

                $usernaam = $_POST['username'];
                $email = $_POST['email'];
                $name = $_POST['name'];
                $phone = $_POST['phone'];
                $address = $_POST['address'];
                $city = $_POST['city'];
                $country = $_POST['country'];

                $query = $connect->query("UPDATE user SET username='$usernaam', email='$email', name='$name', phone='$phone', address='$address', city='$city', country='$country' WHERE user_id=".$_SESSION['userSession']);
                echo "<meta http-equiv='refresh' content='0'>";
            }
            ?>
        </div>
        <div id="menu2" class="tab-pane fade">
            <h3>Wachtwoord veranderen</h3>
            <form name="updateWW" method="post" action="">
                <div class="form-group row">
                    <label for="example-search-input" class="col-2 col-form-label">Huidig wachtwoord</label>
                    <div class="col-10">
                        <input name="oldPass" class="form-control" type="password" value="" id="example-search-input">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="example-search-input" class="col-2 col-form-label">Nieuw wachtwoord</label>
                    <div class="col-10">
                        <input name="newPass" class="form-control" type="password" value="" id="example-search-input">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="example-search-input" class="col-2 col-form-label">Herhaal nieuw wachtwoord</label>
                    <div class="col-10">
                        <input name="newPassAgain" class="form-control" type="password" value="" id="example-search-input">
                    </div>
                </div>
                <input type="submit" class="btn btn-primary" name="btnPassword" value="Update"></input>
            </form>

            <?php
            if (ISSET($_POST['btnPassword'])) {

                $oldPassword = strip_tags($_POST['oldPass']);
                $newPassword = strip_tags($_POST['newPass']);
                $newPasswordAgain = strip_tags($_POST['newPassAgain']);

                $oldPassword = $connect->real_escape_string($oldPassword);
                $newPassword = $connect->real_escape_string($oldPassword);
                $newPasswordAgain = $connect->real_escape_string($newPasswordAgain);

                $oldPasswordHashed = password_hash($oldPassword, PASSWORD_DEFAULT);
                $newPasswordHashed = password_hash($newPassword, PASSWORD_DEFAULT);

                if ($newPassword == $newPasswordAgain && password_verify($oldPassword, $userRow['password'])) {
                    $query = $connect->query("UPDATE user SET password='$newPasswordHashed' WHERE user_id=".$_SESSION['userSession']);
                    echo "<br /><div class='alert alert-success'>
						<span class='glyphicon glyphicon-info-sign'></span> &nbsp; Je wachtwoord is verandert!
					</div>";
                }
                else {
                    echo "<br /><div class='alert alert-danger'>
						<span class='glyphicon glyphicon-info-sign'></span> &nbsp; Wachtwoord onjuist of nieuw wachtwoord komt niet overeen!
					</div>";

                    echo $oldPasswordHashed;
                    echo '<br />';
                    echo $userRow['password'];
                }

                $connect->close();
            }
            ?>

        </div>
    </div>
</div>
</body>
</html>
