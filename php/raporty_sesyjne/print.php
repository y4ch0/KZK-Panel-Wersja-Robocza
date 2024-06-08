<?php
    function ReturnRaporty($uid,$dataOd,$dataDo) {
        $conn = new mysqli("81.171.31.232","y4ch0_03032006","Polkij11!","y4ch0");
        $conn->set_charset("utf8");
        $query = $conn->query("SELECT * FROM raporty_sesyjne WHERE dataDodania <= '$dataDo 23:59:59' AND dataDodania >= '$dataOd 00:00:00' ORDER BY dataDodania DESC");
        if(!array_key_exists("minRaportyData",$_SESSION) || $_SESSION["minRaportyData"] != $dataOd) {
            $_SESSION["minRaportyData"] = $dataOd;
        }
        if(!array_key_exists("maxRaportyData",$_SESSION) || $_SESSION["maxRaportyData"] != $dataDo) {
            $_SESSION["maxRaportyData"] = $dataDo;
        }
        echo "<tr>
                <th>#</th>
                <th>Dodający</th>
                <th>Data dodania</th>
                <th>Opis</th>
                <th></th>
        </tr>";
        while($row = $query->fetch_row()) {
            $nameQuery = $conn->query("SELECT nazwaUzytkownika FROM konta WHERE id = '$row[1]'");
            $nameRow = $nameQuery->fetch_row();
            echo "
            <tr>
                <td>$row[0]</td>
                <td>$nameRow[0]</td>
                <td>$row[3]</td>
                <td style='width:50%;'>$row[2]</td>
                ";
                if($uid == $row[1]) {
                    echo "
                <td>
                    <button class='btn danger' onclick=\"window.location.href='php/raporty_sesyjne/usun.php?id=$row[0]'\">Usuń</button>
                </td>";
                }
            echo "
            </tr>
            ";
        }
    }
?>