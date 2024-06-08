<?php
function ReturnMenu($userId,$webPage) {
    $conn = new mysqli("81.171.31.232","y4ch0_03032006","Polkij11!","y4ch0");
    $conn->set_charset("utf8");
    $result = $conn->query("SELECT typKonta FROM konta WHERE konta.id = '$userId'");
    $row = $result->fetch_row();
    if($row[0] == "Pracownik") {
        $linkSet = [
            "index.php" => [
                "Tytul" => "Strona główna",
                "Ikona" => "fa-solid fa-house",
            ],
            "grafik.php" => [
                "Tytul" => "Grafik pracy",
                "Ikona" => "fa-solid fa-calendar",
            ],
            "pojazdy.php" => [
                "Tytul" => "Spis pojazdów",
                "Ikona" => "fa-solid fa-bus",
            ],
            "sluzby.php" => [
                "Tytul" => "Spis służb",
                "Ikona" => "fa-solid fa-book",
            ],
            "pracownicy.php" => [
                "Tytul" => "Spis pracowników",
                "Ikona" => "fa-solid fa-person",
            ],
        ];
        foreach ($linkSet as $key => $value) {
            echo "<li>";
            if($key == $webPage) {
                echo "<a href='".$key."' class='active'>";
            } else {
                echo "<a href='".$key."'>";
            }
            echo "<i class='".$value["Ikona"]."'></i> ";
            echo $value["Tytul"];
            echo "</a>";
            echo "</li>";
        }
    } elseif ($row[0] == "Dyspozytor") {
        $linkSet = [
            "index.php" => [
                "Tytul" => "Strona główna",
                "Ikona" => "fa-solid fa-house",
            ],
            "grafik.php" => [
                "Tytul" => "Grafik pracy",
                "Ikona" => "fa-solid fa-calendar",
            ],
            "pojazdy.php" => [
                "Tytul" => "Spis pojazdów",
                "Ikona" => "fa-solid fa-bus",
            ],
            "sluzby.php" => [
                "Tytul" => "Spis służb",
                "Ikona" => "fa-solid fa-book",
            ],
            "pracownicy.php" => [
                "Tytul" => "Spis pracowników",
                "Ikona" => "fa-solid fa-person",
            ],
        ];
        foreach ($linkSet as $key => $value) {
            echo "<li>";
            if($key == $webPage) {
                echo "<a href='".$key."' class='active'>";
            } else {
                echo "<a href='".$key."'>";
            }
            echo "<i class='".$value["Ikona"]."'></i> ";
            echo $value["Tytul"];
            echo "</a>";
            echo "</li>";
        }
    } elseif ($row[0] == "Administracja") {
        $linkSet = [
            "index.php" => [
                "Tytul" => "Strona główna",
                "Ikona" => "fa-solid fa-house",
            ],
            "grafik.php" => [
                "Tytul" => "Grafik pracy",
                "Ikona" => "fa-solid fa-calendar",
            ],
            "pojazdy.php" => [
                "Tytul" => "Spis pojazdów",
                "Ikona" => "fa-solid fa-bus",
            ],
            "sluzby.php" => [
                "Tytul" => "Spis służb",
                "Ikona" => "fa-solid fa-book",
            ],
            "pracownicy.php" => [
                "Tytul" => "Spis pracowników",
                "Ikona" => "fa-solid fa-person",
            ],
        ];
        foreach ($linkSet as $key => $value) {
            echo "<li>";
            if($key == $webPage) {
                echo "<a href='".$key."' class='active'>";
            } else {
                echo "<a href='".$key."'>";
            }
            echo "<i class='".$value["Ikona"]."'></i> ";
            echo $value["Tytul"];
            echo "</a>";
            echo "</li>";
        }
    } elseif ($row[0] == "Zarząd") {
        $linkSet = [
            "index.php" => [
                "Tytul" => "Strona główna",
                "Ikona" => "fa-solid fa-house",
            ],
            "grafik.php" => [
                "Tytul" => "Grafik pracy",
                "Ikona" => "fa-solid fa-calendar",
            ],
            "pojazdy.php" => [
                "Tytul" => "Spis pojazdów",
                "Ikona" => "fa-solid fa-bus",
            ],
            "sluzby.php" => [
                "Tytul" => "Spis służb",
                "Ikona" => "fa-solid fa-book",
            ],
            "pracownicy.php" => [
                "Tytul" => "Spis pracowników",
                "Ikona" => "fa-solid fa-person",
            ],
            "dziennik-zdarzen.php" => [
                "Tytul" => "Dziennik zdarzeń",
                "Ikona" => "fa-solid fa-table",
            ],
            "dodaj-artykul.php" => [
                "Tytul" => "Komunikaty",
                "Ikona" => "fa-solid fa-bullhorn",
            ],
            "raporty-sesyjne.php" => [
                "Tytul" => "Raporty sesyjne",
                "Ikona" => "fa-solid fa-pen",
            ],
        ];
        foreach ($linkSet as $key => $value) {
            echo "<li>";
            if($key == $webPage) {
                echo "<a href='".$key."' class='active'>";
            } else {
                echo "<a href='".$key."'>";
            }
            echo "<i class='".$value["Ikona"]."'></i> ";
            echo $value["Tytul"];
            echo "</a>";
            echo "</li>";
        }
    } else {
        header("location:php/logout.php");
    }
}
?>