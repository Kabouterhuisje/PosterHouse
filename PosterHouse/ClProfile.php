<?php

class Profile {

    public function updateInfo($connect) {
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

    public function updatePassword($connect) {
        $oldPassword = strip_tags($_POST['oldPass']);
        $newPassword = strip_tags($_POST['newPass']);
        $newPasswordAgain = strip_tags($_POST['newPassAgain']);

        $oldPassword = $connect->real_escape_string($oldPassword);
        $newPassword = $connect->real_escape_string($newPassword);
        $newPasswordAgain = $connect->real_escape_string($newPasswordAgain);

        $oldPasswordHashed = password_hash($oldPassword, PASSWORD_DEFAULT);
        $newPasswordHashed = password_hash($newPassword, PASSWORD_DEFAULT);
        $newPasswordAgainHashed = password_hash($newPasswordAgain, PASSWORD_DEFAULT);

        if ($_POST['newPass'] == $_POST['newPassAgain'] && password_verify($oldPassword, $userRow['password'])) {
            $query = $connect->query("UPDATE user SET password='$newPasswordHashed' WHERE user_id=".$_SESSION['userSession']);
            echo "<br /><div class='alert alert-success'>
						<span class='glyphicon glyphicon-info-sign'></span> &nbsp; Je wachtwoord is verandert!
					</div>";
        }
        else {
            echo "<br /><div class='alert alert-danger'>
						<span class='glyphicon glyphicon-info-sign'></span> &nbsp; Wachtwoord onjuist of nieuw wachtwoord komt niet overeen!
					</div>";
        }

        $connect->close();
    }
}

?>