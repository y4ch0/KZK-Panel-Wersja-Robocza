<!DOCTYPE html>
<html lang="pl-PL">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
                        if($row[1] == "Dyspozytor" || $row[1] == "Administracja" || $row[1] == "Zarząd") {
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
                        ReturnMenu($uid,"dyspozytor.php");
                    ?>
                    <hr>
                    <li><a href="php/logout.php"><i class="fa-solid fa-arrow-right-from-bracket"></i> Wyloguj się</a></li>
                </ul>
            </nav>
        </div>
    </div>
    <main>
        <div class="section">
            <h2 class="page-title">Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, laboriosam!</h2>
            <hr>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Sit, pariatur nostrum quos voluptatem magnam quia in porro? Culpa doloribus dolor sit harum explicabo porro natus! Ut ratione enim impedit. Eos saepe expedita in repudiandae, quidem qui quasi sit beatae recusandae perspiciatis aspernatur facere deserunt corporis, cumque impedit incidunt amet. Repellendus ab autem laborum doloremque pariatur repellat eos quia quae qui tenetur illo velit eum dolor, nulla nesciunt excepturi amet voluptate consequuntur. Quas incidunt quisquam excepturi quis, debitis sit quidem laborum molestiae quod voluptatem non veniam aspernatur. Consequatur repudiandae aliquam cupiditate ab rem tempora, deleniti corrupti laborum blanditiis dolorem veniam totam et asperiores placeat libero ex impedit, maiores aut suscipit vitae, magni accusantium explicabo earum. Veritatis ipsam consequatur praesentium! Voluptatem, totam velit pariatur soluta perferendis asperiores veniam rem amet voluptatum vero! Fuga praesentium iure accusamus ratione nihil tempore asperiores aut eos, officia veritatis ipsam. Sint aspernatur temporibus quae soluta possimus. Assumenda neque, eos natus hic velit non quasi cumque delectus illo animi aut, corrupti nulla, excepturi placeat. Eligendi sed beatae, laudantium dolorem recusandae, ab, nihil perferendis amet doloribus et placeat. Dolorem quisquam asperiores quibusdam aut temporibus, assumenda libero. Nobis cumque eum accusamus quaerat facere velit fugiat magnam earum vel ipsa corporis pariatur ratione dolorem, sit enim. Hic quia soluta repellendus, illum, illo aliquam voluptatum maxime et dolores cum, officiis quibusdam totam asperiores consequuntur ex pariatur ut cumque nam vel est velit voluptates explicabo. Ducimus voluptas quia, enim tempore blanditiis sapiente illo, ullam, quisquam quod possimus magnam laudantium accusamus veritatis ipsam! Deserunt, veritatis? Molestias, cupiditate iure harum voluptatem consequatur dolor neque accusamus laudantium fugit quis asperiores repellendus velit hic assumenda sint architecto reprehenderit itaque placeat nulla eligendi sit praesentium eum dolores. Sit soluta odit corporis perspiciatis ex ipsum velit iusto placeat, eos, sapiente quia hic rerum aliquid impedit, architecto ab eveniet corrupti.</p>
        </div>
    </main>
</body>
</html>