<?php
    session_start();
    $conn = new mysqli("localhost","root","","y4ch0");
    $pid = $_SESSION['user_id'];
    $bid = $_GET['id'];
    $verify = $conn->query("SELECT * FROM konta WHERE typKonta IN ('Zarząd','Administracja') AND id ='$pid'");
    if($verify !== false && $verify->num_rows == 1) {
        $conn->query("DELETE FROM pojazdy WHERE pojazdy.id = '$bid'");
        $conn->query("DELETE FROM grafik WHERE pojazdId = '$bid'");
        $conn->query("UPDATE konta SET idAutobus = NULL WHERE idAutobus = '$bid'");
        header("location:pojazdy.php");
    } else {
        header("location:php/logout.php");
    }
?>