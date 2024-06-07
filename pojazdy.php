<!DOCTYPE html>
<html lang="pl-PL">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KZK Bielki - Spis pojazdów</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="https://kit.fontawesome.com/7535758241.js" crossorigin="anonymous"></script>
    <script src="js/navbar.js"></script>
</head>
<body>
    <div class="navbar" id="navbar">
        <button class="btn navbar-toggler" onclick="togglerMenu()">
            <i class="fa-solid fa-bars"></i>
        </button>
        <div id="nav-content">
            <p class="logged-info">
                <?php
                    session_start();
                    $uid = $_SESSION['user_id'];
                    $conn = new mysqli("81.171.31.232","y4ch0_03032006","Polkij11!","y4ch0");
                    $result = $conn->query("SELECT nazwaUzytkownika,typKonta,stanowisko FROM konta WHERE konta.id = '$uid'");
                    if($row = $result->fetch_row()) {
                        echo "<span class='title'>".$row[0]."</span>";
                        echo "<span class='subtitle'>".$row[1]." (".$row[2].")</span>";
                    } else {
                        header("location:php/logout.php");
                    }
                ?>
            </p>
            <nav>
                <ul class="navbar-links">
                    <?php
                        include_once("php/menu_print.php");
                        ReturnMenu($uid,"pojazdy.php");
                    ?>
                    <hr>
                    <li><a href="php/logout.php"><i class="fa-solid fa-arrow-right-from-bracket"></i> Wyloguj się</a></li>
                </ul>
            </nav>
        </div>
    </div>
    <main>
        <div class="section">
            <h2 class="page-title">Spis pojazdów</h2>
            <hr>
            <?php
                if($row[1] == "Administracja" || $row[1] == "Zarząd") {
                    echo "
                    <button class='btn warning' onclick=\"window.location.href='dodaj-pojazd.php'\">Dodaj pojazd</button>
                    ";
                }
            ?>
            <div class="responsive-table">
                <table class="ta-center">
                    <tr>
                        <th>#</th>
                        <th>Producent</th>
                        <th>Model</th>
                        <th>Produkcja</th>
                        <th>Data przeg.</th>
                        <th>Nr rejestr.</th>
                        <th>Klasa tab.</th>
                        <th title="Dopuszczony do ruchu?">DDR?</th>
                        <th>Uwagi</th>
                    </tr>
                    <?php
                        $pojazdyQuery = $conn->query("SELECT * FROM pojazdy ORDER BY nrTaborowy");
                        while($row = $pojazdyQuery->fetch_row()) {
                            $ikonka = "";
                            $title = "";
                            switch($row[10]) {
                                case 0:
                                    $ikonka = "<i class='fa-solid fa-xmark' style='color:red;'></i>";
                                    $title = "Nie dopuszczony do ruchu";
                                    break;
                                case 1:
                                    $ikonka = "<i class='fa-solid fa-check' style='color:green;'></i>";
                                    $title = "Dopuszczony do ruchu";
                                    break;
                            };
                            echo "
                            <tr>
                                <td><a href='pojazd.php?id=$row[0]'>$row[7]</a></td>
                                <td>$row[1]</td>
                                <td>$row[2]</td>
                                <td>$row[3]</td>
                                <td>$row[5]</td>
                                <td>$row[6]</td>
                                <td>$row[8]</td>
                                <td title=\"$title\">$ikonka</td>
                                <td>$row[9]</td>
                            </tr>
                            ";
                        }
                    ?>
                </table>
            </div>
        </div>
    </main>
</body>
</html>