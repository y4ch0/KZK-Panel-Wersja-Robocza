<?php
    require_once("../dziennik_zdarzen/dodaj.php");
    session_start();
    $uid = $_SESSION["user_id"];
    $id = $_GET["id"];
    $conn = new mysqli("81.171.31.232","y4ch0_03032006","Polkij11!","y4ch0");
    $conn->set_charset("utf8");
    $verify = $conn->query("SELECT * FROM raporty_sesyjne WHERE id = '$id' AND autorId = '$uid'");
    if($verify !== false && $verify->num_rows == 1) {
        $conn->query("DELETE FROM raporty_sesyjne WHERE id = '$id'");
        header("location:../../raporty-sesyjne.php");
        dodajWiersz($uid,"Usunął raport $id");
    }
?>