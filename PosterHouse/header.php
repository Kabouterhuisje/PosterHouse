<?php

include 'dbconnect.php';

$menuQuery = "SELECT menuitem_name, menuitem_link FROM menuitem ORDER BY id ASC";
$result = $connect->query($menuQuery);

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
                    // Checkt of de link van de huidige pagina overeenkomt met die uit de database
                    if ($menuItemLink == basename($_SERVER['PHP_SELF']))
                    {
                    	echo "<li class='active'><a href='$menuItemLink'>".$row['menuitem_name']."</a></li>";
                    }
                    else
                    {
                    	echo "<li><a href='$menuItemLink'>".$row['menuitem_name']."</a></li>";
                    }
                    
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
                            if ($userRow['role'] == 'Admin') {
                                echo '<li><a href="admin.php">Admin panel</a></li>';
                            }
                            echo '<li><a href="logout.php?logout">Uitloggen</a></li>';
                        }
                        ?>
                    </ul>
                </li>
            </ul>
            <div class="nav navbar-nav form-inline navbar-right" style="padding: 10px;">
                <div class="input-group">
                <form action="producten.php" method="get">
                    <input type="text" name="searchbar" class="form-control"></input>
                    <div class="input-group-btn">
                        <button class="btn btn-default" name="btnsearch"><i class="glyphicon glyphicon-search"></i></button>
                    </div>
                </form>
                </div>
            </div>
        </div><!--/.nav-collapse -->
    </div>
</nav>

<?php
$connect->close();
?>