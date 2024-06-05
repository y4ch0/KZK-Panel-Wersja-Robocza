<?php
    session_start();
    $uid = $_SESSION['user_id'];
    $gid = $_GET['id'];
    $conn = new mysqli("localhost","root","","y4ch0");
    $result = $conn->query("SELECT typKonta FROM konta WHERE konta.id = '$uid'");
    if($row = $result->fetch_row()) {
        if($row[0] == "Zarząd" || $row[0] == "Administracja") {
            $deleteQuery = $conn->query("UPDATE grafik SET pracownikId = NULL WHERE grafik.id = $gid");
            if($deleteQuery) {
                header("location:../../grafik.php");
            } else {
                include_once("../../grafik.php");
                echo "
                    <p class='notification danger'>Brak uprawnień!</p>
                ";
            }
        } else if($row[0] == "Dyspozytor") {
            $verifyQuery = $conn->query("SELECT dyspozytorId FROM grafik WHERE grafik.id = $gid");
            $row1 = $verifyQuery->fetch_row();
            if($row1[0] == $uid) {
                $deleteQuery = $conn->query("UPDATE grafik SET pracownikId = NULL WHERE grafik.id = $gid");
            }
        }
    }
    header("location:../../grafik.php");
?>