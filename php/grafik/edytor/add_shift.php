<?php
    function AddShift($uid,$pracownikId,$sluzbaId,$pojazdId,$data,$notatka) {
        $conn = new mysqli("localhost","root","","y4ch0");
        $verifyQuery = $conn->query("SELECT * FROM grafik WHERE pracownikId = '$pracownikId' AND dyspozytorId = '$uid' AND pojazdId = '$pojazdId' AND sluzbaId = '$sluzbaId' AND dataSesji = '$data'");
        if($verifyQuery->num_rows == 0) {
            $conn->query("INSERT INTO grafik VALUES (NULL,'$pracownikId','$uid','$pojazdId','$sluzbaId','$data','$notatka')");
        } 
    }
?>