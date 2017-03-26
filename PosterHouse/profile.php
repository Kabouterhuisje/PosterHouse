<?php
session_start();
include 'dbconnect.php';
include 'ClProfile.php';

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
        <div id="home" class="tab-pane fade in active"><br />
            <div class="jumbotron">
                <h1>Welkom, <?php echo $userRow['username'];?>!</h1>
                <p>Pas op deze pagina je gegevens aan om zo eenvoudig producten te kunnen bestellen. De gegevens die u hier invuld, zullen automatisch worden ingevuld als u een product wilt kopen! Bespaar tijd en sla uw contactgegevens nu op in het profiel!
                </p>
            </div>
        </div>
        <div id="menu1" class="tab-pane fade">
            <h3>Gegevens</h3>
            <form name="gegevens" method="post" action="">
                <div class="form-group row">
                    <label for="example-text-input" class="col-2 col-form-label">Username</label>
                    <div class="col-10">
                        <input required name="username" class="form-control" type="text" value=<?php echo $userRow['username']?> id="example-text-input">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="example-search-input" class="col-2 col-form-label">Email</label>
                    <div class="col-10">
                        <input required name="email" class="form-control" type="email" value=<?php echo $userRow['email']?> id="example-search-input">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="example-email-input" class="col-2 col-form-label">Naam</label>
                    <div class="col-10">
                        <input required name="name" class="form-control" type="text" value=<?php echo $uName?> id="example-email-input">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="example-url-input" class="col-2 col-form-label">Telefoonnummer</label>
                    <div class="col-10">
                        <input required name="phone" class="form-control" type="tel" maxlength="10" value=<?php echo $uTel?> id="example-url-input">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="example-tel-input" class="col-2 col-form-label">Adres</label>
                    <div class="col-10">
                        <input required name="address" class="form-control" type="text" value=<?php echo $uAddress?> id="example-tel-input">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="example-password-input" class="col-2 col-form-label">Stad</label>
                    <div class="col-10">
                        <input required name="city" class="form-control" type="text" value=<?php echo $uCity?> id="example-password-input">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="example-number-input" class="col-2 col-form-label">Land</label>
                    <div class="col-10">
                        <input required name="country" class="form-control" type="text" value=<?php echo $uCountry?> id="example-number-input">
                    </div>
                </div>
                <input type="submit" class="btn btn-primary" name="btnInfo" value="Update"></input>
            </form>

            <?php
            $profile = new Profile();
            if (ISSET($_POST['btnInfo'])) {
                $profile->updateInfo($DBconnect);
            }
            ?>
        </div>
        <div id="menu2" class="tab-pane fade">
            <h3>Wachtwoord veranderen</h3>
            <form name="updateWW" method="post" action="">
                <div class="form-group row">
                    <label for="example-search-input" class="col-2 col-form-label">Huidig wachtwoord</label>
                    <div class="col-10">
                        <input required name="oldPass" class="form-control" type="password" value="" id="example-search-input">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="example-search-input" class="col-2 col-form-label">Nieuw wachtwoord</label>
                    <div class="col-10">
                        <input required name="newPass" class="form-control" type="password" value="" id="example-search-input">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="example-search-input" class="col-2 col-form-label">Herhaal nieuw wachtwoord</label>
                    <div class="col-10">
                        <input required name="newPassAgain" class="form-control" type="password" value="" id="example-search-input">
                    </div>
                </div>
                <input type="submit" class="btn btn-primary" name="btnPassword" value="Update"></input>
            </form>

            <?php
            if (ISSET($_POST['btnPassword'])) {

                $profile->updatePassword($DBconnect);
            }
            ?>

        </div>
    </div>
</div>
</body>
</html>
