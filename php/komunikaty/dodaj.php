<?php
    function addMessage($pid,$tytul,$tresc) {
        $data = date("Y-m-d H:i:s");
        $conn = new mysqli("81.171.31.232","y4ch0_03032006","Polkij11!","y4ch0");
        $conn->set_charset("utf8");
        $tresc = nl2br($tresc);
        $verify = $conn->query("SELECT typKonta FROM konta WHERE id = '$pid' and typKonta = 'Zarząd'");
        if($verify !== false && $verify->num_rows) {
            $conn->query("INSERT INTO aktualnosci_public VALUES (NULL,'$pid','$data','$tytul','$tresc')");
            echo "<p class='notification confirmation'>Dodano komunikat.</p>";
        } else {
            header("location:../logout.php");
        }
    }
?>