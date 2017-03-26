<?php

class Authenticatie {

    public function login($connect) {
        $email = strip_tags($_POST['email']);
        $password = strip_tags($_POST['password']);

        $email = $connect->real_escape_string($email);
        $password = $connect->real_escape_string($password);

        $query = $connect->query("SELECT user_id, email, password FROM user WHERE email='$email'");
        $row=$query->fetch_array();

        $count = $query->num_rows; // if email/password are correct returns must be 1 row

        if (password_verify($password, $row['password']) && $count==1) {
            $_SESSION['userSession'] = $row['user_id'];
            header("Location: index.php");
        } else {
            $msg = "<div class='alert alert-danger'>
					<span class='glyphicon glyphicon-info-sign'></span> &nbsp; Invalid Username or Password !
				</div>";
        }
        $connect->close();
    }

    public function register($connect) {
        $uname = strip_tags($_POST['username']);
        $email = strip_tags($_POST['email']);
        $upass = strip_tags($_POST['password']);
        $upersonname = strip_tags($_POST['name']);
        $uphone = strip_tags($_POST['phone']);
        $uaddress = strip_tags($_POST['address']);
        $ucity = strip_tags($_POST['city']);
        $ucountry = strip_tags($_POST['country']);

        $uname = $connect->real_escape_string($uname);
        $email = $connect->real_escape_string($email);
        $upass = $connect->real_escape_string($upass);
        $upersonname = $connect->real_escape_string($upersonname);
        $uphone = $connect->real_escape_string($uphone);
        $uaddress = $connect->real_escape_string($uaddress);
        $ucity = $connect->real_escape_string($ucity);
        $ucountry = $connect->real_escape_string($ucountry);

        $hashed_password = password_hash($upass, PASSWORD_DEFAULT);

        $check_email = $connect->query("SELECT email FROM user WHERE email='$email'");
        $count=$check_email->num_rows;

        if ($count==0) {

            $query = "INSERT INTO user(username,password,email,role,name,phone,address,city,country) VALUES('$uname','$hashed_password','$email','Gebruiker','$upersonname','$uphone','$uaddress','$ucity','$ucountry')";

            if ($connect->query($query)) {
                $msg = "<div class='alert alert-success'>
						<span class='glyphicon glyphicon-info-sign'></span> &nbsp; successfully registered !
					</div>";
            }else {
                $msg = "<div class='alert alert-danger'>
						<span class='glyphicon glyphicon-info-sign'></span> &nbsp; error while registering !
					</div>";
            }

        } else {


            $msg = "<div class='alert alert-danger'>
					<span class='glyphicon glyphicon-info-sign'></span> &nbsp; sorry email already taken !
				</div>";

        }

        $connect->close();
    }
}

?>