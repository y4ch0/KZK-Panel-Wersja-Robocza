<?php
    function ReturnGrafik_Edytor($uid,$data) {
        $conn = new mysqli("81.171.31.232","y4ch0_03032006","Polkij11!","y4ch0");
        $pracownicyQuery = $conn->query("SELECT * FROM grafik WHERE dataSesji = '$data' AND pracownikId IS NOT NULL");
        echo "<h2>Edytujesz dzień: ".$data."</h2>";
        echo "<div class='responsive-table no-bg'>
        <table class='ta-center'>";
        echo "
            <tr>
                <th>Pracownik</th>
                <th>Pojazd</th>
                <th>Służba</th>
            </tr>
        ";
        while($row = $pracownicyQuery->fetch_row()) {
            echo "<tr>";
            $pracownikName = $conn->query("SELECT nazwaUzytkownika FROM konta WHERE id = $row[1]");
            $pojazdName = $conn->query("SELECT producent,model,nrTaborowy FROM pojazdy WHERE id = $row[3]");
            $sluzbaName = $conn->query("SELECT kodLinii,przystPoczatkowy FROM sluzby WHERE id = $row[4]");
            $row = $pracownikName->fetch_row();
            echo "<td>".$row[0]."</td>";
            $row = $pojazdName->fetch_row();
            echo "<td>".$row[0]." ".$row[1]." #".$row[2]."</td>";
            $row = $sluzbaName->fetch_row();
            echo "<td>".$row[0]." (".$row[1].")</td>";
            echo "</tr>";
        }
        echo "</table></div>";
    }
?>