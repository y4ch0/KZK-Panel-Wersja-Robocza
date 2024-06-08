<?php
if(!$_SESSION) {
    session_start();
}
function ReturnGrafik($userId,$minGrafikData,$maxGrafikData) {
    $conn = new mysqli("81.171.31.232","y4ch0_03032006","Polkij11!","y4ch0");
    $conn->set_charset("utf8");
    $result = $conn->query("SELECT typKonta FROM konta WHERE konta.id = '$userId'");
    $row = $result->fetch_row();
    if(!array_key_exists("minGrafikData",$_SESSION) || $_SESSION["minGrafikData"] != $minGrafikData) {
        $_SESSION["minGrafikData"] = $minGrafikData;
    }
    if(!array_key_exists("maxGrafikData",$_SESSION) || $_SESSION["maxGrafikData"] != $maxGrafikData) {
        $_SESSION["maxGrafikData"] = $maxGrafikData;
    }
    switch($row[0]) {
        case "Pracownik":
            $grafikQuery = $conn->query("SELECT grafik.id,pracownikId,dyspozytorId,pojazdId,sluzbaId,dataSesji,notatka FROM grafik,konta WHERE pracownikId = konta.id AND dataSesji >= '$minGrafikData' AND dataSesji <= '$maxGrafikData' ORDER BY dataSesji DESC");
            echo "<tr>
                    <th>#</th>
                    <th>Pracownik</th>
                    <th>Dyspozytor</th>
                    <th>Pojazd</th>
                    <th>Służba</th>
                    <th>Data</th>
                    <th>Uwagi</th>
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
                echo "<td><a href='pojazd.php?id=$grafikRow[3]'><span class='tag primary'>".$subRow[2]."</span> ".$subRow[0]." ".$subRow[1]." (".$subRow[3].")</a></td>";
                $subQuery = $conn->query("SELECT kodLinii,przystPoczatkowy,plikRozklad,id FROM sluzby WHERE sluzby.id = $grafikRow[4]");
                $subRow = $subQuery->fetch_row();
                switch($subRow[2]) {
                    case "n/d":
                        echo "<td>".$subRow[0]." <span class='tag danger'>Brak kursówki</span></td>";
                        break;
                    default:
                        echo "<td>".$subRow[0]."</td>";
                        break;
                }
                echo "<td>".$grafikRow[5]."</td>";
                echo "<td>".$grafikRow[6]."</td>";
                echo "</tr>";
            };
            break;
        case "Dyspozytor":
            $grafikQuery = $conn->query("SELECT grafik.id,pracownikId,dyspozytorId,pojazdId,sluzbaId,dataSesji,notatka FROM grafik,konta WHERE pracownikId = konta.id AND dataSesji >= '$minGrafikData' AND dataSesji <= '$maxGrafikData' ORDER BY dataSesji DESC");
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
                echo "<td><a href='pojazd.php?id=$grafikRow[3]'><span class='tag primary'>".$subRow[2]."</span> ".$subRow[0]." ".$subRow[1]." (".$subRow[3].")</a></td>";
                $subQuery = $conn->query("SELECT kodLinii,przystPoczatkowy,plikRozklad FROM sluzby WHERE sluzby.id = $grafikRow[4]");
                $subRow = $subQuery->fetch_row();
                switch($subRow[2]) {
                    case "n/d":
                        echo "<td>".$subRow[0]." <span class='tag danger'>Brak kursówki</span></td>";
                        break;
                    default:
                        echo "<td>".$subRow[0]."</td>";
                        break;
                }
                echo "<td>".$grafikRow[5]."</td>";
                echo "<td>".$grafikRow[6]."</td>";
                if($grafikRow[2] == $userId) {
                    echo "<td>
                    <button class='btn danger' onclick=\"window.location.href='php/grafik/usun.php?id=$grafikRow[0]'\">Usuń</button>
                    </td>";
                } else {
                    echo "<td></td>";
                }
                echo "</tr>";
            };
            break;
        case "Administracja":
            $grafikQuery = $conn->query("SELECT grafik.id,pracownikId,dyspozytorId,pojazdId,sluzbaId,dataSesji,notatka FROM grafik,konta WHERE pracownikId = konta.id AND dataSesji >= '$minGrafikData' AND dataSesji <= '$maxGrafikData' ORDER BY dataSesji DESC");
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
                echo "<td><a href='pojazd.php?id=$grafikRow[3]'><span class='tag primary'>".$subRow[2]."</span> ".$subRow[0]." ".$subRow[1]." (".$subRow[3].")</a></td>";
                $subQuery = $conn->query("SELECT kodLinii,przystPoczatkowy,plikRozklad FROM sluzby WHERE sluzby.id = $grafikRow[4]");
                $subRow = $subQuery->fetch_row();
                switch($subRow[2]) {
                    case "n/d":
                        echo "<td>".$subRow[0]." <span class='tag danger'>Brak kursówki</span></td>";
                        break;
                    default:
                        echo "<td>".$subRow[0]."</td>";
                        break;
                }
                echo "<td>".$grafikRow[5]."</td>";
                echo "<td>".$grafikRow[6]."</td>";
                echo "<td>
                <button class='btn danger' onclick=\"window.location.href='php/grafik/usun.php?id=$grafikRow[0]'\">Usuń</button>
                </td>";
                echo "</tr>";
            };
            break;
        case "Zarząd":
            $grafikQuery = $conn->query("SELECT grafik.id,pracownikId,dyspozytorId,pojazdId,sluzbaId,dataSesji,notatka FROM grafik,konta WHERE pracownikId = konta.id AND dataSesji >= '$minGrafikData' AND dataSesji <= '$maxGrafikData' ORDER BY dataSesji DESC");
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
                echo "<td><a href='pojazd.php?id=$grafikRow[3]'><span class='tag primary'>".$subRow[2]."</span> ".$subRow[0]." ".$subRow[1]." (".$subRow[3].")</a></td>";
                $subQuery = $conn->query("SELECT kodLinii,przystPoczatkowy,plikRozklad FROM sluzby WHERE sluzby.id = $grafikRow[4]");
                $subRow = $subQuery->fetch_row();
                switch($subRow[2]) {
                    case "n/d":
                        echo "<td>".$subRow[0]." <span class='tag danger'>Brak kursówki</span></td>";
                        break;
                    default:
                        echo "<td>".$subRow[0]."</td>";
                        break;
                }
                echo "<td>".$grafikRow[5]."</td>";
                echo "<td>".$grafikRow[6]."</td>";
                echo "<td>
                <button class='btn danger' onclick=\"window.location.href='php/grafik/usun.php?id=$grafikRow[0]'\">Usuń</button>
                </td>";
                echo "</tr>";
            };
            break;
    }
}
?>