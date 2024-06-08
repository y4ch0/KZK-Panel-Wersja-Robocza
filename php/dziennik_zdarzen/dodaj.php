<?php
    function dodajWiersz($uid,$opis) {
        $conn = new mysqli("81.171.31.232","y4ch0_03032006","Polkij11!","y4ch0");
        $conn->set_charset("utf8");
        $data = date("Y-m-d H:i:s");
        $conn->query("INSERT INTO dziennik_zdarzen VALUES (NULL,$uid,'Pracownik: $uid, opis: $opis','$data')");
    }
?>