<?php
    function DodajPojazd($pid,$producent,$model,$klasaTaborowa,$dataRejestracji,$waznoscPrzeglad,$nrRejestracyjny,$nrTaborowy,$uwagi,$dostepnosc,$dataProdukcji) {
        $conn = new mysqli("localhost","root","","y4ch0");
        $verify = $conn->query("SELECT * FROM konta WHERE typKonta IN ('Zarząd','Administracja') AND id ='$pid'");
        if($verify !== false && $verify->num_rows == 1) {
            $conn->query("INSERT INTO pojazdy VALUE (NULL,'$producent','$model','$dataProdukcji','$dataRejestracji','$waznoscPrzeglad','$nrRejestracyjny','$nrTaborowy','$klasaTaborowa','$uwagi','$dostepnosc')");
        } else {
            header("location:php/logout.php");
        }
    }
?>