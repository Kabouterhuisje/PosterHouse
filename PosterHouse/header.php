<?php

$DBhost = "localhost";
$DBuser = "root";
$DBpass = "";
$DBname = "posterhouse_database";

$DBcon = new MySQLi($DBhost,$DBuser,$DBpass,$DBname);

if ($DBcon->connect_errno) {
    die("ERROR : -> ".$DBcon->connect_error);
}

$menuQuery = "SELECT menuitem_name, menuitem_link FROM menuitem ORDER BY id ASC";
$result = $DBcon->query($menuQuery);

while($row = $result->fetch_array()) {
    $rows[] = $row;
}

?>
<!-- Navigatiebar -->
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
                <?php
                foreach ($rows as $row) {
                    $menuItemLink = $row['menuitem_link'];
                    echo "<li><a href='$menuItemLink'>".$row['menuitem_name']."</a></li>";
                }
                ?>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="winkelmandje.php"><span class="glyphicon glyphicon-shopping-cart"></span> Winkelwagen</a></li>
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
                        }
                        if (isset($_SESSION['userSession'])) {
                            echo '<li><a href="profile.php">Mijn Account</a></li>';
                            echo '<li><a href="logout.php?logout">Uitloggen</a></li>';
                        }
                        ?>
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

<?php
$DBcon->close();
?>