<!DOCTYPE html>
<html lang="pl-PL">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KZK Bielki - Spis służb</title>
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
                        echo "<span class='title'>".$row[0]."</span>";
                        echo "<span class='subtitle'>".$row[1]." (".$row[2].") <small>".$row[3]."</small></span>";
                    } else {
                        header("location:php/logout.php");
                    }
                ?>
            </p>
            <nav>
                <ul class="navbar-links">
                    <?php
                        include_once("php/menu_print.php");
                        ReturnMenu($uid,"sluzby.php");
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
            <h2 class="page-title">Spis służb</h2>
            <hr>
            <div class="responsive-table">
                <table class="ta-center">
                    <tr>
                        <th>Kod służby</th>
                        <th>Linia</th>
                        <th>Przystanek początkowy</th>
                        <th>Godz. rozp.</th>
                        <th>Godz. zak.</th>
                        <th title="Dopuszczone klasy taborowe">DKT</th>
                    </tr>
                    <?php
                        $sluzbyQuery = $conn->query("SELECT * FROM sluzby ORDER BY id");
                        while($row = $sluzbyQuery->fetch_row()) {
                            $cleantime1 = substr($row[4],0,-3);
                            $cleantime2 = substr($row[5],0,-3);
                            $kursowkaLink = null;
                            if($row[7] == "n/d") {
                                $kursowkaLink = $row[1]." <span class='tag danger'>Brak kursówki</span>";
                            } else {
                                $kursowkaLink = "<a href='img/kursowki/$row[7]'>".$row[1]."</a>";
                            }
                            echo "
                            <tr>
                                <td>".$kursowkaLink."</td>
                                <td>".$row[2]."</td>
                                <td>".$row[3]."</td>
                                <td>".$cleantime1."</td>
                                <td>".$cleantime2."</td>
                                <td>".$row[6]."</td>
                            </tr>
                            ";
                        }
                    ?>
                </table>
            </div>
        </div>
    </main>
</body>
</html>