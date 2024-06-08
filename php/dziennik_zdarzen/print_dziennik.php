<?php
    if(!$_SESSION) {
        session_start();
    }
    function ReturnDziennik($userId,$minData,$maxData) {
        $conn = new mysqli("81.171.31.232","y4ch0_03032006","Polkij11!","y4ch0");
        $conn->set_charset("utf8");
        $result = $conn->query("SELECT typKonta FROM konta WHERE konta.id = '$userId'");
        $row = $result->fetch_row();
        if(!array_key_exists("minDziennikData",$_SESSION) || $_SESSION["minDziennikData"] != $minData) {
            $_SESSION["minDziennikData"] = $minData;
        }
        if(!array_key_exists("maxDziennikData",$_SESSION) || $_SESSION["maxDziennikData"] != $maxData) {
            $_SESSION["maxDziennikData"] = $maxData;
        }
        $Query = $conn->query("SELECT * FROM dziennik_zdarzen WHERE data >= '$minData' AND data <= '$maxData' ORDER BY data DESC");
                echo "<tr>
                        <th>#</th>
                        <th>Użytkownik</th>
                        <th>Data</th>
                        <th>Opis</th>
                </tr>";
                while($Row = $Query->fetch_row()) {
                    $pracownikQuery = $conn->query("SELECT nazwaUzytkownika FROM konta WHERE id = '$Row[1]'");
                    $pracownikName = $pracownikQuery->fetch_row();
                    echo "<tr>";
                    echo "<td>".$Row[0]."</td>";
                    echo "<td>".$pracownikName[0]."</td>";
                    echo "<td>".$Row[3]."</td>";
                    echo "<td>".$Row[2]."</td>";
                    echo "</tr>";
                };
    }
?>