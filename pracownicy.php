<!DOCTYPE html>
<html lang="pl-PL">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KZK Bielki - Spis pojazdów</title>
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
                        ReturnMenu($uid,"pracownicy.php");
                    ?>
                    <hr>
                    <li><a href="php/logout.php"><i class="fa-solid fa-arrow-right-from-bracket"></i> Wyloguj się</a></li>
                </ul>
            </nav>
        </div>
    </div>
    <main>
        <div class="section">
            <h2 class="page-title">Spis pracowników</h2>
            <hr>
            <div class="responsive-table">
                <table class="ta-center">
                    <tr>
                        <th>Użytkownik</th>
                        <th>Discord ID</th>
                        <th>Nr służbowy</th>
                        <th>Stanowisko</th>
                        <th>Stały przydział</th>
                        <th>Data zatrudnienia</th>
                        <th>Zawieszony?</th>
                        <th>Uprawnienia dodatkowe</th>
                    </tr>
                    <?php
                        $pojazdyQuery = $conn->query("SELECT * FROM konta ORDER BY id");
                        while($row = $pojazdyQuery->fetch_row()) {
                            echo "<tr>
                                <td>".$row[1]."</td>
                                <td>".$row[0]."</td>
                                <td>".$row[4]."</td>
                                <td>".$row[2]." (".$row[3].")</td>
                            ";
                            if($row[8] != "") {
                                $stalyPrzydzial = $conn->query("SELECT producent,model,nrTaborowy FROM pojazdy WHERE id = '$row[8]'");
                                $row1 = $stalyPrzydzial->fetch_row();
                                echo "<td><a href='pojazd.php?id=$row[8]'>#$row1[2] $row1[0] $row1[1]</a></td>";
                            } else {
                                echo "<td>-</td>";
                            }
                            echo "
                            <td>".$row[5]."</td>
                            ";
                            switch($row[6]) {
                                case 0:
                                    echo "<td><i class='fa-solid fa-xmark' style='color:red;'></i></td>";
                                    break;
                                case 1:
                                    echo "<td><i class='fa-solid fa-check' style='color:green;'></i></td>";
                                    break;
                            };
                            echo "<td>";
                            $klasaC = $row[9];
                            $kontrolerB = $row[10];
                            $nadzor = $row[11];
                            switch($klasaC) {
                                case 1:
                                    echo "<span title='UD-1; Uprawnienie na kierowanie pojazdem przegubowym (klasy C)'>UD-1</span> ";
                                    break;
                                default:
                                    break;
                            }
                            switch($kontrolerB) {
                                case 1:
                                    echo "<span title='UD-2; Uprawnienie na pracę w formie kontrolera biletów'>UD-2</span> ";
                                    break;
                                default:
                                    break;
                            }
                            switch($nadzor) {
                                case 1:
                                    echo "<span title='UD-3; Uprawnienie na pracę w inspektoracie nadzoru ruchu'>UD-3</span>";
                                    break;
                                default:
                                    break;
                            }
                            echo "</tr>";
                        }
                    ?>
                </table>
            </div>
        </div>
    </main>
</body>
</html>