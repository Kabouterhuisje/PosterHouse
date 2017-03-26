<?php
session_start();
if (isset($_SESSION['userSession'])!="") {
	header("Location: index.php");
}
include 'dbconnect.php';
include 'ClAuthenticatie.php';

$auth = new Authenticatie();

if(isset($_POST['btn-signup'])) {
    $auth->register($connect);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Registrerenm</title>
<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
<link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen"> 
<link rel="stylesheet" href="style.css" type="text/css" />

</head>
<body>

<div class="signin-form">

	<div class="container">
     
        
       <form class="form-signin" method="post" id="register-form">
      
        <h2 class="form-signin-heading">Sign Up</h2><hr />
        
        <?php
		if (isset($msg)) {
			echo $msg;
		}
		?>
          
        <div class="form-group">
        <input type="text" class="form-control" placeholder="Username" name="username" required  />
        </div>
        
        <div class="form-group">
        <input type="email" class="form-control" placeholder="Email address" name="email" required  />
        <span id="check-e"></span>
        </div>
        
        <div class="form-group">
        <input type="password" class="form-control" placeholder="Password" name="password" required  />
        </div>

       <div class="form-group">
           <input type="text" class="form-control" placeholder="Name" name="name" required  />
       </div>

       <div class="form-group">
           <input type="phone" class="form-control" placeholder="Phone number" name="phone" maxlength="10" required  />
       </div>

       <div class="form-group">
           <input type="text" class="form-control" placeholder="Address" name="address" required  />
       </div>

       <div class="form-group">
           <input type="text" class="form-control" placeholder="City" name="city" required  />
       </div>

       <div class="form-group">
           <input type="text" class="form-control" placeholder="Country" name="country" required  />
       </div>

           <hr />
        
        <div class="form-group">
            <button type="submit" class="btn btn-default" name="btn-signup">
    		<span class="glyphicon glyphicon-log-in"></span> &nbsp; Create Account
			</button> 
            <a href="login.php" class="btn btn-default" style="float:right;">Log In Here</a>
        </div> 
      
      </form>

    </div>
    
</div>

</body>
</html>