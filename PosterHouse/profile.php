<?php
session_start();
include_once 'dbconnect.php';

if (isset($_SESSION['userSession'])) {
    $query = $DBcon->query("SELECT * FROM user WHERE user_id=".$_SESSION['userSession']);
    $userRow=$query->fetch_array();
}



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Bootstrap Case</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php">PosterHouse</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li class="active"><a href="index.php">Home</a></li>
                <li><a href="producten.php">Producten</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="winkelwagen.php"><span class="glyphicon glyphicon-shopping-cart"></span> Winkelwagen</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <?php
                        if (isset($_SESSION['userSession'])) {
                            echo $userRow['username'];
                        }
                        else {
                            echo 'Profiel';
                        }
                        ?><span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <?php
                        if (!isset($_SESSION['userSession'])) {
                            echo '<li><a href="login.php">Inloggen</a></li>';
                            echo '<li role="separator" class="divider"></li>';
                        }
                        ?>
                        <li><a href="#">Mijn Account</a></li>
                        <li><a href="logout.php?logout">Uitloggen</a></li>
                    </ul>
                </li>
            </ul>
            <div class="nav navbar-nav form-inline navbar-right" style="padding: 10px;">
                <div class="input-group">
                    <input type="text" class="form-control"></input>
                    <div class="input-group-btn">
                        <button class="btn btn-default"><i class="glyphicon glyphicon-search"></i></button>
                    </div>
                </div>
            </div>

        </div><!--/.nav-collapse -->
    </div>
</nav>

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
                        <input name="name" class="form-control" type="text" value=<?php echo $userRow['name']?> id="example-email-input">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="example-url-input" class="col-2 col-form-label">Telefoonnummer</label>
                    <div class="col-10">
                        <input name="phone" class="form-control" type="tel" value=<?php echo $userRow['phone']?> id="example-url-input">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="example-tel-input" class="col-2 col-form-label">Adres</label>
                    <div class="col-10">
                        <input name="address" class="form-control" type="text" value=<?php echo $userRow['address']?> id="example-tel-input">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="example-password-input" class="col-2 col-form-label">Stad</label>
                    <div class="col-10">
                        <input name="city" class="form-control" type="text" value=<?php echo $userRow['city']?> id="example-password-input">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="example-number-input" class="col-2 col-form-label">Land</label>
                    <div class="col-10">
                        <input name="country" class="form-control" type="text" value=<?php echo $userRow['country']?> id="example-number-input">
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

                $query = $DBcon->query("UPDATE user SET username='$usernaam', email='$email', name='$name', phone='$phone', address='$address', city='$city', country='$country' WHERE user_id=".$_SESSION['userSession']);

                $DBcon->close();

            }
            ?>
        </div>
        <div id="menu2" class="tab-pane fade">
            <h3>Wachtwoord veranderen</h3>
            <form name="updateWW" method="post" action="">
                <div class="form-group row">
                    <label for="example-search-input" class="col-2 col-form-label">Huidig wachtwoord</label>
                    <div class="col-10">
                        <input class="form-control" type="password" value="" id="example-search-input">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="example-search-input" class="col-2 col-form-label">Nieuw wachtwoord</label>
                    <div class="col-10">
                        <input class="form-control" type="password" value="" id="example-search-input">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="example-search-input" class="col-2 col-form-label">Herhaal nieuw wachtwoord</label>
                    <div class="col-10">
                        <input class="form-control" type="password" value="" id="example-search-input">
                    </div>
                </div>
                <input type="submit" class="btn btn-primary" name="btnInfo" value="Update"></input>
            </form>
        </div>
    </div>
</div>

</body>
</html>
