<?php
    function addRaport($uid,$tresc) {
        $conn = new mysqli("81.171.31.232","y4ch0_03032006","Polkij11!","y4ch0");
        $conn->set_charset("utf8");
        $data = date("Y-m-d H:i:s");
        $tresc = nl2br($tresc);
        $query = $conn->query("INSERT INTO raporty_sesyjne VALUES (NULL,'$uid','$tresc','$data')");
        if($query) {
            header("location:raporty-sesyjne.php");
        } else {
            echo "<p class='notification danger'>Błąd - nie dodano raportu.</p>";
        }
    }
?>