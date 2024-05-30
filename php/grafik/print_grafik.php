<?php
function ReturnGrafik($userId,$minGrafikData,$maxGrafikData) {
    $conn = new mysqli("localhost","root","","y4ch0");
    $result = $conn->query("SELECT typKonta FROM konta WHERE konta.id = '$userId'");
    $row = $result->fetch_row();
    switch($row[0]) {
        case "Pracownik":
            break;
        case "Dyspozytor":
            break;
        case "Administracja":
            break;
        case "Zarząd":
            $grafikQuery = $conn->query("SELECT grafik.id,pracownikId,dyspozytorId,pojazdId,sluzbaId,dataSesji,notatka FROM grafik,konta WHERE pracownikId = konta.id AND dataSesji >= '$minGrafikData' AND dataSesji <= '$maxGrafikData' ORDER BY dataSesji");
            echo "<tr>
                    <th>#</th>
                    <th>Pracownik</th>
                    <th>Dyspozytor</th>
                    <th>Pojazd</th>
                    <th>Służba</th>
                    <th>Data</th>
                    <th>Uwagi</th>
                    <th></th>
            </tr>";
            while($grafikRow = $grafikQuery->fetch_row()) {
                echo "<tr>";
                echo "<td>".$grafikRow[0]."</td>";
                $subQuery = $conn->query("SELECT nazwaUzytkownika FROM konta WHERE konta.id = $grafikRow[1]");
                $subRow = $subQuery->fetch_row();
                echo "<td>".$subRow[0]."</td>";
                $subQuery = $conn->query("SELECT nazwaUzytkownika FROM konta WHERE konta.id = $grafikRow[2]");
                $subRow = $subQuery->fetch_row();
                echo "<td>".$subRow[0]."</td>";
                $subQuery = $conn->query("SELECT producent,model,nrTaborowy,rejestracja FROM pojazdy WHERE pojazdy.id = $grafikRow[3]");
                $subRow = $subQuery->fetch_row();
                echo "<td>".$subRow[0]." ".$subRow[1]." ".$subRow[2]." (".$subRow[3].")</td>";
                $subQuery = $conn->query("SELECT kodLinii,przystPoczatkowy,plikRozklad FROM sluzby WHERE sluzby.id = $grafikRow[4]");
                $subRow = $subQuery->fetch_row();
                echo "<td><a href='img/kursowki/$subRow[2]'>".$subRow[0]." (".$subRow[1].")</a></td>";
                echo "<td>".$grafikRow[5]."</td>";
                echo "<td>".$grafikRow[6]."</td>";
                echo "<td>".$grafikRow[6]."</td>";
                echo "</tr>";
            }
    }
}
?>