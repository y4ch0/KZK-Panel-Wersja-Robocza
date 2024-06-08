<?php
    session_start();
    $uid = $_SESSION['user_id'];
    $conn = new mysqli("81.171.31.232","y4ch0_03032006","Polkij11!","y4ch0");
    $conn->set_charset("utf8");
?>
<!DOCTYPE html>
<html lang="pl-PL">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KZK Bielki - Dodawanie raportu</title>
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
                    $result = $conn->query("SELECT nazwaUzytkownika,typKonta,stanowisko,nrSluzbowy FROM konta WHERE konta.id = '$uid'");
                    if($row1 = $result->fetch_row()) {
                        if($row1[1] == "Zarząd" || $row1[1] == "Administracja") {
                            echo "<span class='title'>".$row1[0]."</span>";
                            echo "<span class='subtitle'>".$row1[1]." (".$row1[2].") <small>".$row1[3]."</small></span>";
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
                        ReturnMenu($uid,"dodaj-raport.php");
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
            <h2 class="page-title">Dodawanie raportu</h2>
            <hr>
            <form method="post">
                <div class="input-row">
                    <label for="tresc">Treść:</label>
                    <textarea name="tresc" id="tresc" rows="10" style="white-space: pre-wrap;"></textarea>
                </div>
                <input type="submit" value="Dodaj raport" class="btn confirmation" name="Submit">
                <?php
                    require_once("php/raporty_sesyjne/dodaj.php");
                    require_once("php/dziennik_zdarzen/dodaj.php");
                    if(isset($_POST["Submit"])) {
                        if(!empty($_POST["tresc"])) {
                            addRaport($uid,$_POST["tresc"]);
                            dodajWiersz($uid,"Dodano raport \"".$_POST["tresc"]."\"");
                        }
                    }
                ?>
        </form>
        </div>
    </main>
</body>
</html>