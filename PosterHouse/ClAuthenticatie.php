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
}

?>