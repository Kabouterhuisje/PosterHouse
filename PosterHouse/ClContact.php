<?php

class Contact {

    public function sendMessage($connect) {
        $formName = $_POST['name'];
        $formEmail = $_POST['email'];
        $formTitle = $_POST['subject'];
        $formMessage = $_POST['message'];

        if ($formName == null || $formMessage == null || $formEmail == null)
        {
            echo '<script>alert("Je formulier is niet verzonden!")</script>';
        }
        else {
            $query = "INSERT INTO message (form_name,form_email,form_title,form_message) VALUES ('$formName','$formEmail','$formTitle','$formMessage')";

            if ($connect->query($query)) {
                echo '<script>alert("Je formulier is verzonden!")</script>';
            }
            else {
                echo '<script>alert("Er is helaas iets niet helemaal goed gegaan. Probeer het nog eens!")</script>';
            }
        }
    }

}

?>