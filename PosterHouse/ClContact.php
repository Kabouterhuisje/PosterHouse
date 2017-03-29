<?php
class Contact {
	// Functie die een bericht verstuurt
    public function sendMessage($connect) {
    	// Zet de gesubmitte gegevens in variabelen
        $formName = $_POST['name'];
        $formEmail = $_POST['email'];
        $formTitle = $_POST['subject'];
        $formMessage = $_POST['message'];

        // Als de volgende variabele leeg zijn gelaten wordt het formulier niet verstuurd
        if ($formName == null || $formMessage == null || $formEmail == null)
        {
        	// Laat een melding aan de gebruiker
            echo '<script>alert("Je formulier is niet verzonden!")</script>';
        }
        else 
        {
        	// Voegt de gegevens toe aan een query die data insert naar de database
            $query = "INSERT INTO message (form_name,form_email,form_title,form_message) VALUES ('$formName','$formEmail','$formTitle','$formMessage')";

            // Query wordt uitgevoerd als alles goed gaat
            if ($connect->query($query)) {
                echo '<script>alert("Je formulier is verzonden!")</script>';
            }
            // Zoniet dan krijgt de gebruiker een melding dat er iets fout is gegaan
            else {
                echo '<script>alert("Er is helaas iets niet helemaal goed gegaan. Probeer het nog eens!")</script>';
            }
        }
    }
}
?>