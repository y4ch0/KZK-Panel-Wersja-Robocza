<!DOCTYPE html>
<html lang="pl-PL">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KZK Bielki - Raporty sesyjne</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="https://kit.fontawesome.com/7535758241.js" crossorigin="anonymous"></script>
    <script src="js/navbar.js"></script>
    <link rel="shortcut icon" href="img/kzk_logo_main.ico" type="image/x-icon">
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
                    $conn->set_charset("utf8");
                    $result = $conn->query("SELECT nazwaUzytkownika,typKonta,stanowisko,nrSluzbowy FROM konta WHERE konta.id = '$uid'");
                    if($row = $result->fetch_row()) {
                        if($row[1] == "Zarząd" || $row[1] == "Administracja") {
                            echo "<span class='title'>".$row[0]."</span>";
                            echo "<span class='subtitle'>".$row[1]." (".$row[2].") <small>".$row[3]."</small></span>";
                        } else {
                            header("location:php/logout.php");
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
                        ReturnMenu($uid,"raporty-sesyjne.php");
                    ?>
                    <hr>
                    <li><a href="php/logout.php"><i class="fa-solid fa-arrow-right-from-bracket"></i> Wyloguj się</a></li>
                    <?php
                        echo "<li style='padding-left:1rem;margin-top:1rem;'>".date("Y")." &copy; y4ch0</li>";
                    ?>
                </ul>
            </nav>
        </div>
    </div>
    <main>
        <div class="section">
            <h2 class="page-title">Raporty sesyjne</h2>
            <hr>
            <form method="post">
                <div class="d-grid grid-2-columns">
                    <div class="input-row">
                        <label for="grafikData1">Data od:</label>
                        <input type="date" id="grafikData1" name="minData" autocomplete="off">
                    </div>
                    <div class="input-row">
                        <label for="grafikData2">Data do:</label>
                        <input type="date" id="grafikData2" name="maxData" autocomplete="off">
                    </div>
                </div>
                <input class="btn primary" value="Sprawdź raporty" type="submit" name="Submit">
            </form>
            <button class="btn secondary m-lr-2" onclick="window.location.href='dodaj-raport.php'">Dodaj raport</button>
            <div class="responsive-table">
                <table class="ta-center">
                    <?php
                        require_once("php/raporty_sesyjne/print.php");
                        if(isset($_POST["Submit"])) {
                            if(!empty($_POST['minData']) && !empty($_POST['maxData']))  {
                                ReturnRaporty($uid,$_POST["minData"],$_POST["maxData"] );
                            } else {
                                echo "
                                <p class='notification danger'>Proszę wprowadzić obie daty.</p>
                                ";
                            }
                        } else if(array_key_exists("minRaportyData",$_SESSION) && array_key_exists("maxRaportyData",$_SESSION)) {
                            ReturnRaporty($uid,$_SESSION["minRaportyData"],$_SESSION["maxRaportyData"] );
                            echo "<p><span class='tag warning'><i class=\"fa-solid fa-circle-exclamation\"></i> Wyświetlam zakres raportów z zapisanego: ".$_SESSION["minRaportyData"]." - ".$_SESSION["maxRaportyData"]."</span></p>";
                            return;
                        }
                    ?>
                </table>
            </div>
        </div>
    </main>
</body>
</html>