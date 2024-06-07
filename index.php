<!DOCTYPE html>
<html lang="pl-PL">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KZK Bielki</title>
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
                        ReturnMenu($uid,"index.php");
                    ?>
                    <hr>
                    <li><a href="php/logout.php"><i class="fa-solid fa-arrow-right-from-bracket"></i> Wyloguj się</a></li>
                </ul>
            </nav>
        </div>
    </div>
    <main>
        <div class="section h-fit">
            <h2 class="page-title">Strona główna</h2>
            <hr>
        </div>
        <div class="section no-bg d-grid no-tr-items grid-2-columns">
            <div>
                <h3>Dzisiejsza służba</h3>
                <hr>
                <?php
                    $date = date("Y-m-d");
                    $query = $conn->query("SELECT * FROM grafik WHERE pracownikId = '$uid' AND dataSesji = '$date'");
                    if($row = $query->fetch_row()) {
                        $subQuery = $conn->query("SELECT kodLinii,plikRozklad,przystPoczatkowy,godzRozp,godzZako FROM sluzby WHERE id = '$row[4]'");
                        $subRow = $subQuery->fetch_row();
                        $cleantime1 = substr($subRow[3],0,-3);
                        $cleantime2 = substr($subRow[4],0,-3);
                        echo "<h1 class='ta-center'><a href='img/kursowki/$subRow[1]'>$subRow[0]</a></h1>";
                        echo "<p class='ta-center'><big><i>$cleantime1 - $cleantime2</i></big></p>";
                        echo "<p class='ta-center'>Miejsce rozpoczęcia: <b>$subRow[2]</b> ($cleantime1)</p>";
                        $subQuery1 = $conn->query("SELECT producent,model,nrTaborowy FROM pojazdy WHERE id = '$row[3]'");
                        $subRow1 = $subQuery1->fetch_row();
                        echo "<p class='ta-center'><a href='pojazd.php?id=$row[3]'>$subRow1[0] $subRow1[1] #$subRow1[2]</a></p>";
                        echo "<p class='ta-center'><i>Uwagi dyspozytora: $row[6]</i></p>";
                    } else {
                        echo "<p class='m-lr-4' style='display:flex;justify-content:center;align-items:center;width:100%;height:max-content;'><big><i class=\"fa-solid fa-check\" style='color:green;'></i> Masz dzisiaj wolne.</big></p>";
                    }
                ?>
            </div>
            <div>
                <h3>Najnowszy komunikat</h3>
                <hr>
                <?php
                    $query = $conn->query("SELECT * FROM aktualnosci_public WHERE dataDodania = (SELECT MAX(dataDodania) FROM aktualnosci_public);");
                    if($row = $query->fetch_row()) {
                        echo "<p><b>$row[3]</b> <i>$row[2]</i></p>";
                        echo "<p>$row[4]</p>";
                    }
                ?>
            </div>
        </div>
        <div class="section">
            <h2>Komunikaty:</h2>
            <hr>
            <?php
                $query = $conn->query("SELECT * FROM aktualnosci_public ORDER BY dataDodania DESC");
                while($row = $query->fetch_row()) {
                    echo "<p><b>$row[3]</b> <i>$row[2]</i></p>";
                    echo "<p>$row[4]</p>";
                    echo "<hr>";
                }
            ?>
            </div>
    </main>
</body>
</html>