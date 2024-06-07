<?php
    function EditVehicleData($pid,$bid,$producent,$model,$klasaTaborowa,$dataRejestracji,$waznoscPrzeglad,$nrRejestracyjny,$nrTaborowy,$uwagi,$dostepnosc) {
        $conn = new mysqli("81.171.31.232","y4ch0_03032006","Polkij11!","y4ch0");
        $query = $conn->query("UPDATE pojazdy SET producent = '$producent', model = '$model', klasaTab = '$klasaTaborowa', dataRejestracji = '$dataRejestracji', terminBadanie = '$waznoscPrzeglad', rejestracja = '$nrRejestracyjny', nrTaborowy = '$nrTaborowy', notatka = '$uwagi', DDR = '$dostepnosc' WHERE id = '$bid'");
        if($query) {
            echo "<p class='notification confirmation'>Operacja wykonana pomyślnie.</p>";
        } else {
            echo "<p class='notification danger'>Błąd podczas wykonywania operacji.</p>";
        };
        
    }
?>