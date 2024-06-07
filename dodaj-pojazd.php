<?php
    session_start();
    $uid = $_SESSION['user_id'];
    $conn = new mysqli("81.171.31.232","y4ch0_03032006","Polkij11!","y4ch0");
?>
<!DOCTYPE html>
<html lang="pl-PL">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KZK Bielki - Dodawanie pojazdu</title>
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
                        if($row1[1] == "Administracja" || $row1[1] == "Zarząd") {
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
                        ReturnMenu($uid,"dodaj-pojazd.php");
                    ?>
                    <hr>
                    <li><a href="php/logout.php"><i class="fa-solid fa-arrow-right-from-bracket"></i> Wyloguj się</a></li>
                </ul>
            </nav>
        </div>
    </div>
    <main>
        <div class="section">
            <h2 class="page-title">Dodawanie pojazdu</h2>
            <hr>
            <form method="post">
                <div class="no-bg d-grid no-tr-items grid-3-columns m-lr-2">
                    <div class="no-bg">
                        <h3>Dane techniczne</h3>
                        <table class="m-lr-2">
                            <tr>
                                <td><b>Producent</b></td>
                                <td class="ta-right"><input type="text" name="producent" class="w-full"></td>
                            </tr>
                            <tr>
                                <td><b>Model</b></td>
                                <td class="ta-right"><input type="text" name="model" class="w-full"></td>
                            </tr>
                            <tr>
                                <td><b>Klasa taborowa</b></td>
                                <td class="ta-right">
                                    <?php
                                        $klasyTaborowe = [
                                            "A",
                                            "B",
                                            "C",
                                            "D"
                                        ];
                                        echo "<select name='klasaTaborowa'>";
                                        foreach($klasyTaborowe as $value) {
                                            echo "<option value='$value'>$value</option>";
                                        }
                                        echo "</select>";
                                    ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="no-bg">
                        <h3>Dane prawne</h3>
                        <table class="m-lr-2">
                            <tr>
                                <td><b>Data rejestracji</b></td>
                                <td class="ta-right"><input type="date" name="dataRejestracji" class="w-full"></td>
                            </tr>
                            <tr>
                                <td><b>Data produkcji</b></td>
                                <td class="ta-right"><input type="number" name="dataProdukcji" class="w-full"></td>
                            </tr>
                            <tr>
                                <td><b>Ważność prz. tech.</b></td>
                                <td class="ta-right"><input type="date" name="dataPrzegladu" class="w-full"></td>
                            </tr>
                            <tr>
                                <td><b>Nr rejestracyjny</b></td>
                                <td class="ta-right"><input type="text" name="nrRejestracyjny" class="w-full"></td>
                            </tr>
                        </table>
                    </div>
                    <div class="no-bg">
                        <h3>Dane pozostałe</h3>
                        <table class="m-lr-2">
                            <tr>
                                <td><b>Nr ewidencyjny</b></td>
                                <td class="ta-right"><input type="text" name="nrTaborowy" class="w-full"></td>
                            </tr>
                            <tr>
                                <td><b>Uwagi</b></td>
                                <td class="ta-right"><input type="text" name="uwagi" class="w-full"></td>
                            </tr>
                            <tr>
                                <td><b>Dostępność</b></td>
                                <td class="ta-right">
                                    <?php
                                        $DDR = [
                                            "0" => "NIE",
                                            "1" => "TAK",
                                        ];
                                        echo "<select name='DDR'>";
                                        foreach($DDR as $key=>$value) {
                                            if($key == $row[10]) {
                                                echo "<option value='$key' selected>$value</option>";
                                            } else {
                                                echo "<option value='$key'>$value</option>";
                                            }
                                        }
                                        echo "</select>";
                                    ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="h-fit">
                    <input type="submit" value="Dodaj pojazd" class="btn confirmation" name="changeDataSubmit">
                    <?php
                        require_once("php/pojazd/dodaj.php");
                        require_once("php/dziennik_zdarzen/dodaj.php");
                        if(isset($_POST["changeDataSubmit"])) {
                            if(!empty($_POST["producent"]) && !empty($_POST["model"]) && !empty($_POST["dataRejestracji"]) && !empty($_POST["dataPrzegladu"]) && !empty($_POST["nrRejestracyjny"]) && !empty($_POST["nrTaborowy"]) && !empty($_POST["dataProdukcji"])) {
                                DodajPojazd($uid,$_POST["producent"],$_POST["model"],$_POST["DDR"],$_POST["dataRejestracji"],$_POST["dataPrzegladu"],$_POST["nrRejestracyjny"],$_POST["nrTaborowy"],$_POST["uwagi"],$_POST["DDR"],$_POST["dataProdukcji"]);
                                dodajWiersz($uid,"Dodano pojazd ".$_POST["producent"]." ".$_POST["model"]." #".$_POST["nrTaborowy"]."");
                            }
                        }
                    ?>
                </div>
        </form>
        </div>
    </main>
</body>
</html>