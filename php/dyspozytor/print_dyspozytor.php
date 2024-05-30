<?php
function ReturnMenu($userId) {
    $conn = new mysqli("localhost","root","","y4ch0");
    $result = $conn->query("SELECT typKonta FROM konta WHERE konta.id = '$userId'");
    $row = $result->fetch_row();
    switch($row[0]) {
        case "Pracownik":
            header("location:../logout.php");
    }
}
?>