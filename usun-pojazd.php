<?php
    require_once("php/dziennik_zdarzen/dodaj.php");
    session_start();
    $conn = new mysqli("81.171.31.232","y4ch0_03032006","Polkij11!","y4ch0");
    $pid = $_SESSION['user_id'];
    $bid = $_GET['id'];
    $verify = $conn->query("SELECT * FROM konta WHERE typKonta IN ('Zarząd','Administracja') AND id ='$pid'");
    if($verify !== false && $verify->num_rows == 1) {
        $pojazdInfo = $conn->query("SELECT producent,model,nrTaborowy FROM pojazdy WHERE id = '$bid'");
        $row = $pojazdInfo->fetch_row();
        $conn->query("DELETE FROM pojazdy WHERE pojazdy.id = '$bid'");
        $conn->query("DELETE FROM grafik WHERE pojazdId = '$bid'");
        $conn->query("UPDATE konta SET idAutobus = NULL WHERE idAutobus = '$bid'");
        dodajWiersz($uid,"Usunięto pojazd ".$row[0]." ".$row[1]." #".$row[2]."");
        header("location:pojazdy.php");
    } else {
        header("location:php/logout.php");
    }
?>