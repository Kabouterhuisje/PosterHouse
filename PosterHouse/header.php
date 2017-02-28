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