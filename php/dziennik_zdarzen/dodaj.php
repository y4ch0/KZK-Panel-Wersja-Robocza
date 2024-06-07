<?php
    function dodajWiersz($uid,$opis) {
        $conn = new mysqli("localhost","root","","y4ch0");
        $data = date("Y-m-d H:i:s");
        $conn->query("INSERT INTO dziennik_zdarzen VALUES (NULL,'$data','Pracownik: $uid, opis: $opis')");
    }
?>