<?php
    session_start();
    $uid = $_SESSION['user_id'];
    $conn = new mysqli("81.171.31.232","y4ch0_03032006","Polkij11!","y4ch0");
    $conn->set_charset("utf8");
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
                        echo "<span class='title'>".$row1[0]."</span>";
                        echo "<span class='subtitle'>".$row1[1]." (".$row1[2].") <small>".$row1[3]."</small></span>";
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
                    <?php
                        echo "<li style='padding-left:1rem;margin-top:1rem;'>".date("Y")." &copy; y4ch0</li>";
                    ?>
                </ul>
            </nav>
        </div>
    </div>
    <main>
        <div class="section">
            <h2 class="page-title">Karta pojazdu <?php echo "#".$row[7] ?></h2>
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
            <?php
                if($row1[1] == "Administracja" || $row1[1] == "Zarząd") {
                    echo "
                    <button class='btn warning' onclick=\"window.location.href='edytuj-pojazd.php?id=$pid'\">Edytuj pojazd</button>
                    <button class='btn danger' onclick=\"window.location.href='usun-pojazd.php?id=$pid'\">Usuń pojazd</button>
                    ";
                }
            ?>
        </div>
        <div class="section no-bg d-grid no-tr-items grid-3-columns">
            <div>
                <h3>Dane techniczne</h3>
                <table class="m-lr-2">
                    <tr>
                        <td><b>Producent</b></td>
                        <td class="ta-right"><?php echo $row[1] ?></td>
                    </tr>
                    <tr>
                        <td><b>Model</b></td>
                        <td class="ta-right"><?php echo $row[2] ?></td>
                    </tr>
                    <tr>
                        <td><b>Klasa taborowa</b></td>
                        <td class="ta-right"><?php echo $row[8] ?></td>
                    </tr>
                </table>
            </div>
            <div>
                <h3>Dane prawne</h3>
                <table class="m-lr-2">
                    <tr>
                        <td><b>Data rejestracji</b></td>
                        <td class="ta-right"><span class="tag primary"><?php echo $row[4] ?></span></td>
                    </tr>
                    <tr>
                        <td><b>Ważność prz. tech.</b></td>
                        <td class="ta-right"><span class="tag"><?php echo $row[5] ?></span></td>
                    </tr>
                    <tr>
                        <td><b>Nr rejestracyjny</b></td>
                        <td class="ta-right"><?php echo $row[6] ?></td>
                    </tr>
                </table>
            </div>
            <div>
                <h3>Dane pozostałe</h3>
                <table class="m-lr-2">
                    <tr>
                        <td><b>Nr ewidencyjny</b></td>
                        <td class="ta-right">#<?php echo $row[7] ?></td>
                    </tr>
                    <tr>
                        <td><b>Uwagi</b></td>
                        <td class="ta-right"><?php echo $row[9] ?></td>
                    </tr>
                    <tr>
                        <td><b>Dostępność</b></td>
                        <?php
                            $ikonka = "";
                            switch($row[10]) {
                                case 0:
                                    $ikonka = "<i class='fa-solid fa-xmark' style='color:red;'></i>";
                                    break;
                                case 1:
                                    $ikonka = "<i class='fa-solid fa-check' style='color:green;'></i>";
                                    break;
                            };
                        ?>
                        <td class="ta-right"><?php echo $ikonka ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </main>
</body>
</html>