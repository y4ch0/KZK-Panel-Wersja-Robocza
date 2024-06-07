<?php
    
    function AddShift($uid,$pracownikId,$sluzbaId,$pojazdId,$data,$notatka) {
        $conn = new mysqli("81.171.31.232","y4ch0_03032006","Polkij11!","y4ch0");
        $verifyQuery = $conn->query("SELECT * FROM grafik WHERE pracownikId = '$pracownikId' AND dyspozytorId = '$uid' AND pojazdId = '$pojazdId' AND sluzbaId = '$sluzbaId' AND dataSesji = '$data'");
        if($verifyQuery->num_rows == 0) {
            dodajWiersz($uid,"Dodano przydział pracownik: $pracownikId, dyspozytor: $uid, pojazd: $pojazdId, data: $data, notatka: $notatka");
            $conn->query("INSERT INTO grafik VALUES (NULL,'$pracownikId','$uid','$pojazdId','$sluzbaId','$data','$notatka')");
        } 
    }
?>