<!DOCTYPE html>
<html lang="pl-PL">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KZK Bielki - Grafik</title>
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
                    $conn = new mysqli("localhost","root","","y4ch0");
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
                        ReturnMenu($uid,"grafik.php");
                    ?>
                    <hr>
                    <li><a href="php/logout.php"><i class="fa-solid fa-arrow-right-from-bracket"></i> Wyloguj się</a></li>
                </ul>
            </nav>
        </div>
    </div>
    <main>
        <div class="section">
            <h2 class="page-title">Grafik pracy</h2>
            <hr>
            <form method="post">
                <div class="d-grid grid-2-columns">
                    <div class="input-row">
                        <label for="grafikData1">Data od:</label>
                        <input type="date" id="grafikData1" name="minGrafikData" autocomplete="off">
                    </div>
                    <div class="input-row">
                        <label for="grafikData2">Data do:</label>
                        <input type="date" id="grafikData2" name="maxGrafikData" autocomplete="off">
                    </div>
                </div>
                <input class="btn primary" value="Sprawdź grafik" type="submit" name="grafikSubmit">
            </form>
            <?php
                $q1 = $conn->query("SELECT typKonta FROM konta WHERE id = '$uid'");
                if($row = $q1->fetch_row()) {
                    if($row[0] == "Zarząd" || $row[0] == "Administracja" || $row[0] == "Dyspozytor") {
                        echo "<button class=\"btn secondary m-lr-2\" onclick=\"window.location.href='edytuj-grafik.php'\">Edytuj grafik</button>";
                    }
                }
            ?>
            <div class="responsive-table">
                <table class="ta-center">
                    <?php
                        require_once("php/grafik/print_grafik.php");
                        if(isset($_POST["grafikSubmit"])) {
                            if(!empty($_POST['minGrafikData']) && !empty($_POST['maxGrafikData']))  {

                                ReturnGrafik($uid,$_POST["minGrafikData"],$_POST["maxGrafikData"] );
                            } else {
                                echo "
                                <p class='notification danger'>Proszę wprowadzić obie daty.</p>
                                ";
                            }
                        } else if(array_key_exists("minGrafikData",$_SESSION) && array_key_exists("maxGrafikData",$_SESSION)) {
                            ReturnGrafik($uid,$_SESSION["minGrafikData"],$_SESSION["maxGrafikData"] );
                            echo "<p><span class='tag warning'><i class=\"fa-solid fa-circle-exclamation\"></i> Wyświetlam zakres grafiku z zapisanego: ".$_SESSION["minGrafikData"]." - ".$_SESSION["maxGrafikData"]."</span></p>";
                            return;
                        }
                    ?>
                </table>
            </div>
        </div>
    </main>
</body>
</html>