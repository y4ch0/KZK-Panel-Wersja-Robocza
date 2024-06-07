<?php
    session_start();
    $uid = $_SESSION['user_id'];
    $conn = new mysqli("81.171.31.232","y4ch0_03032006","Polkij11!","y4ch0");
    $pid = $_GET['id'];
    $pojazdQuery = $conn->query("SELECT * FROM pojazdy WHERE pojazdy.id = $pid");
    if(!($row = $pojazdQuery->fetch_row())) {
        header('location:index.php');
    }
?>
<!DOCTYPE html>
<html lang="pl-PL">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KZK Bielki - Karta pojazdu #<?php echo $row[7] ?></title>
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
            <h2 class="page-title">Edycja pojazdu <?php echo "#".$row[7] ?></h2>
            <hr>
            <div>
                <div class="w-50 mx-auto bp-m">
                    <?php
                        $image = "img/pojazdy/".$row[7].".jpg";
                        if(!file_exists($image)) {
                            $image = "img/no_image.png";
                        }
                    ?>
                    <img src=<?php echo $image ?> alt="zdjecie pojazdu" class="w-full" id="bus-photo">
                </div>
            </div>
        </div>
        <form method="post">
            <div class="section no-bg d-grid no-tr-items grid-3-columns">
                <div>
                    <h3>Dane techniczne</h3>
                    <table class="m-lr-2">
                        <tr>
                            <td><b>Producent</b></td>
                            <td class="ta-right"><input type="text" name="producent" value="<?php echo $row[1] ?>" class="w-full"></td>
                        </tr>
                        <tr>
                            <td><b>Model</b></td>
                            <td class="ta-right"><input type="text" name="model" value="<?php echo $row[2] ?>" class="w-full"></td>
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
                                        if($value == $row[8]) {
                                            echo "<option value='$value' selected>$value</option>";
                                        } else {
                                            echo "<option value='$value'>$value</option>";
                                        }
                                    }
                                    echo "</select>";
                                ?>
                            </td>
                        </tr>
                    </table>
                </div>
                <div>
                    <h3>Dane prawne</h3>
                    <table class="m-lr-2">
                        <tr>
                            <td><b>Data rejestracji</b></td>
                            <td class="ta-right"><input type="date" name="dataRejestracji" value="<?php echo $row[4] ?>" class="w-full"></td>
                        </tr>
                        <tr>
                            <td><b>Ważność prz. tech.</b></td>
                            <td class="ta-right"><input type="date" name="dataPrzegladu" value="<?php echo $row[5] ?>" class="w-full"></td>
                        </tr>
                        <tr>
                            <td><b>Nr rejestracyjny</b></td>
                            <td class="ta-right"><input type="text" name="nrRejestracyjny" value="<?php echo $row[6] ?>" class="w-full"></td>
                        </tr>
                    </table>
                </div>
                <div>
                    <h3>Dane pozostałe</h3>
                    <table class="m-lr-2">
                        <tr>
                            <td><b>Nr ewidencyjny</b></td>
                            <td class="ta-right"><input type="text" name="nrTaborowy" value="<?php echo $row[7] ?>" class="w-full"></td>
                        </tr>
                        <tr>
                            <td><b>Uwagi</b></td>
                            <td class="ta-right"><input type="text" name="uwagi" value="<?php echo $row[9] ?>" class="w-full"></td>
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
            <div class="section h-fit">
                <input type="submit" value="Zmień dane" class="btn confirmation" name="changeDataSubmit">
                <?php
                    require_once("php/pojazd/edytuj_dane.php");
                    if(isset($_POST["changeDataSubmit"])) {
                        EditVehicleData($pid,$_GET["id"],$_POST["producent"],$_POST["model"],$_POST["klasaTaborowa"],$_POST["dataRejestracji"],$_POST["dataPrzegladu"],$_POST["nrRejestracyjny"],$_POST["nrTaborowy"],$_POST["uwagi"],$_POST["DDR"]);
                        dodajWiersz($uid,"Edytowano pojazd ".$_POST["producent"]." ".$_POST["model"]." #".$_POST["nrTaborowy"]."");
                        echo "<meta http-equiv='refresh' content='0'>";
                    }
                ?>
            </div>
        </form>
    </main>
</body>
</html>