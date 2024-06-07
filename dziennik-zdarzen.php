<!DOCTYPE html>
<html lang="pl-PL">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KZK Bielki - Dziennik zdarzeń</title>
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
                        if($row[1] == "Zarząd" || $row[1] == "Administracja") {
                            echo "<span class='title'>".$row[0]."</span>";
                            echo "<span class='subtitle'>".$row[1]." (".$row[2].")</span>";
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
                        ReturnMenu($uid,"dziennik-zdarzen.php");
                    ?>
                    <hr>
                    <li><a href="php/logout.php"><i class="fa-solid fa-arrow-right-from-bracket"></i> Wyloguj się</a></li>
                </ul>
            </nav>
        </div>
    </div>
    <main>
        <div class="section">
            <h2 class="page-title">Dziennik zdarzeń</h2>
            <hr>
            <form method="post">
                <div class="d-grid grid-2-columns">
                    <div class="input-row">
                        <label for="grafikData1">Data od:</label>
                        <input type="date" id="grafikData1" name="minDziennikData" autocomplete="off">
                    </div>
                    <div class="input-row">
                        <label for="grafikData2">Data do:</label>
                        <input type="date" id="grafikData2" name="maxDziennikData" autocomplete="off">
                    </div>
                </div>
                <input class="btn primary" value="Sprawdź dziennik zdarzeń" type="submit" name="grafikSubmit">
            </form>
            <div class="responsive-table">
                <table class="ta-center">
                    <?php
                        require_once("php/dziennik_zdarzen/print_dziennik.php");
                        if(isset($_POST["grafikSubmit"])) {
                            if(!empty($_POST['minDziennikData']) && !empty($_POST['maxDziennikData']))  {
                                ReturnDziennik($uid,$_POST["minDziennikData"],$_POST["maxDziennikData"] );
                            } else {
                                echo "
                                <p class='notification danger'>Proszę wprowadzić obie daty.</p>
                                ";
                            }
                        } else if(array_key_exists("minDziennikData",$_SESSION) && array_key_exists("maxDziennikData",$_SESSION)) {
                            ReturnDziennik($uid,$_SESSION["minDziennikData"],$_SESSION["maxDziennikData"] );
                            echo "<p><span class='tag warning'><i class=\"fa-solid fa-circle-exclamation\"></i> Wyświetlam zakres dziennika zdarzeń z zapisanego: ".$_SESSION["minDziennikData"]." - ".$_SESSION["maxDziennikData"]."</span></p>";
                            return;
                        } else {
                            ReturnDziennik($uid,date("Y-m-d 00:00:00"),date("Y-m-d H:i:s"));
                        }
                    ?>
                </table>
            </div>
        </div>
    </main>
</body>
</html>