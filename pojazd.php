<!DOCTYPE html>
<html lang="pl-PL">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="https://kit.fontawesome.com/7535758241.js" crossorigin="anonymous"></script>
    <script src="navbar.js"></script>
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
            <h2 class="page-title">Karta pojazdu #123</h2>
            <hr>
            <div>
                <div class="w-50 mx-auto bp-m">
                    <img src="form_header.png" alt="zdjecie pojazdu" class="w-full" id="bus-photo">
                </div>
            </div>
        </div>
        <div class="section no-bg d-grid no-tr-items grid-3-columns">
            <div>
                <h3>Dane techniczne</h3>
                <table class="m-lr-2">
                    <tr>
                        <td><b>Producent</b></td>
                        <td class="ta-right">Solaris</td>
                    </tr>
                    <tr>
                        <td><b>Model</b></td>
                        <td class="ta-right">Urbino 12</td>
                    </tr>
                    <tr>
                        <td><b>Klasa taborowa</b></td>
                        <td class="ta-right">B</td>
                    </tr>
                </table>
            </div>
            <div>
                <h3>Dane prawne</h3>
                <table class="m-lr-2">
                    <tr>
                        <td><b>Data rejestracji</b></td>
                        <td class="ta-right"><span class="tag danger">2002/03/20</span></td>
                    </tr>
                    <tr>
                        <td><b>Ważność prz. tech.</b></td>
                        <td class="ta-right"><span class="tag warning">2024/05/30</span></td>
                    </tr>
                    <tr>
                        <td><b>Nr rejestracyjny</b></td>
                        <td class="ta-right">RBI YGHZ1</td>
                    </tr>
                </table>
            </div>
            <div>
                <h3>Dane pozostałe</h3>
                <table class="m-lr-2">
                    <tr>
                        <td><b>Nr ewidencyjny</b></td>
                        <td class="ta-right">#123</td>
                    </tr>
                    <tr>
                        <td><b>Uwagi</b></td>
                        <td class="ta-right">-</td>
                    </tr>
                    <tr>
                        <td><b>Dostępność</b></td>
                        <td class="ta-right"><i class="fa-solid fa-check" style="color:#3aa043"></i></td>
                    </tr>
                </table>
            </div>
        </div>
    </main>
</body>
</html>