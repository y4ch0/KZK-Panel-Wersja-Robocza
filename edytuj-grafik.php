<?php
    session_start();
    $uid = $_SESSION['user_id'];
    $conn = new mysqli("localhost","root","","y4ch0");
?>
<!DOCTYPE html>
<html lang="pl-PL">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KZK Bielki - Edytor grafiku</title>
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
                    $result = $conn->query("SELECT nazwaUzytkownika,typKonta,stanowisko FROM konta WHERE konta.id = '$uid'");
                    if($row1 = $result->fetch_row()) {
                        if($row1[1] == "Administracja" || $row1[1] == "Zarząd" || $row1[1] == "Dyspozytor") {
                            echo "<span class='title'>".$row1[0]."</span>";
                            echo "<span class='subtitle'>".$row1[1]." (".$row1[2].")</span>";
                        } else {
                            header("location:index.php");
                        }
                    } else {
                        header("location:php/logout.php");
                    }
                ?>
            </p>
            <nav>
                <ul class="navbar-links">
                    <?php
                        include_once("php/menu_print.php");
                        ReturnMenu($uid,"pojazd.php");
                    ?>
                    <hr>
                    <li><a href="php/logout.php"><i class="fa-solid fa-arrow-right-from-bracket"></i> Wyloguj się</a></li>
                </ul>
            </nav>
        </div>
    </div>
    <main>
        <div class="section">
            <h2 class="page-title">Edytor grafiku</h2>
            <hr>
            <form method="post">
                <div class="input-row">
                    <label for="grafikData1">Dzień:</label>
                    <input type="date" id="grafikData1" name="grafikData" autocomplete="off">
                </div>
                <input class="btn primary" value="Wyświetl grafik" type="submit" name="grafikSubmit">
            </form>
            <?php
                if(isset($_POST["grafikSubmit"])) {
                    if(empty($_POST['grafikData'])) {
                        echo "
                            <p class='notification danger'>Proszę wprowadzić datę.</p>
                        ";
                    }
                }
            ?>
        </div>
        <div class="section no-bg d-grid no-tr-items grid-2-columns">
            <div>
                <h2>Dodaj zmianę</h2>
                <form method="post" class="w-full">
                    <div class="input-row">
                        <label for="selectPracownik">Pracownik:</label>
                        <select id="selectPracownik" name="pracownikId">
                            <?php
                                $dzien = null;
                                if(!empty($_POST["grafikData"])) {
                                    $dzien = $_POST["grafikData"];
                                } else if (!empty($_SESSION["edytor_Dzien"])) {
                                    $dzien = $_SESSION["edytor_Dzien"];
                                }
                                $query = $conn->query("SELECT * FROM konta WHERE czyKierowanieAutobus = 1 AND konta.id NOT IN (SELECT pracownikId FROM grafik WHERE dataSesji = '$dzien') AND czyZawieszony = 0");
                                while($row = $query->fetch_row()) {
                                    echo "<option value='$row[0]'>$row[1]</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <div class="input-row">
                        <label for="selectSluzba">Służba:</label>
                        <select id="selectSluzba" name="sluzbaId">
                            <?php
                                $dzien = null;
                                if(!empty($_POST["grafikData"])) {
                                    $dzien = $_POST["grafikData"];
                                } else if (!empty($_SESSION["edytor_Dzien"])) {
                                    $dzien = $_SESSION["edytor_Dzien"];
                                }
                                $query = $conn->query("SELECT * FROM sluzby WHERE sluzby.id NOT IN (SELECT sluzbaId FROM grafik WHERE dataSesji = '$dzien')");
                                while($row = $query->fetch_row()) {
                                    echo "<option value='$row[0]'>$row[1] ($row[3]); kl. tab.: $row[6]</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <div class="input-row">
                        <label for="selectPojazd">Pojazd:</label>
                        <select id="selectPojazd" name="pojazdId">
                            <?php
                                $dzien = null;
                                if(!empty($_POST["grafikData"])) {
                                    $dzien = $_POST["grafikData"];
                                } else if (!empty($_SESSION["edytor_Dzien"])) {
                                    $dzien = $_SESSION["edytor_Dzien"];
                                }
                                $query = $conn->query("SELECT * FROM pojazdy WHERE klasaTab IN ('A','B','C') AND pojazdy.id NOT IN (SELECT pojazdId FROM grafik WHERE dataSesji = '$dzien') AND DDR = 1 ORDER BY nrTaborowy");
                                while($row = $query->fetch_row()) {
                                    echo "<option value='$row[0]'>#$row[7] $row[1] $row[2] ($row[8])</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <div class="input-row">
                        <label for="areaNotatka">Notatka:</label>
                        <textarea name="notatka" id="areaNotatka"></textarea>
                    </div>
                    <input class="btn confirmation" value="Dodaj zmianę" name="grafikAddSubmit" type="submit">
                </form>
                <?php
                    require_once("php/grafik/edytor/add_shift.php");
                    if(isset($_POST["grafikAddSubmit"])) {
                        if(!empty($_POST['pracownikId']) && !empty($_POST['sluzbaId']) && !empty($_POST['pojazdId']) && !empty($dzien)) {
                            AddShift($uid,$_POST['pracownikId'],$_POST['sluzbaId'],$_POST['pojazdId'],$dzien,$_POST['notatka']);
                            echo "<meta http-equiv='refresh' content='0'>";
                            echo "<p class='notification confirmation'>Pomyślnie dodano zmianę.</p>";
                        } else {
                            echo "<p class='notification danger'>Nie dodano zmiany ze względu na błąd aplikacji.</p>";
                        }
                    }
                ?>
            </div>
            <?php
                require_once("php/grafik/edytor/wyswietl_grafik.php");
                if(isset($_POST["grafikSubmit"])) {
                    if(!empty($_POST['grafikData']))  {
                        echo "<div>";
                        ReturnGrafik_Edytor($uid,$_POST['grafikData']);
                        $_SESSION["edytor_Dzien"] = $_POST['grafikData'];
                        echo "</div>";
                    };
                } else if(!empty($_SESSION["edytor_Dzien"])) {
                    echo "<div>";
                    echo "<p class='m-lr-4'><span class='tag warning'><i class=\"fa-solid fa-circle-exclamation\"></i> Wyświetlam grafik dla zapisanego dnia: ".$_SESSION["edytor_Dzien"]."</span></p>";
                    ReturnGrafik_Edytor($uid,$_SESSION["edytor_Dzien"]);
                    echo "</div>";
                }
            ?>
        </div>
    </main>
</body>
</html>