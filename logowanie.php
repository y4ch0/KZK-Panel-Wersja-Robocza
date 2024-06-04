<?php

/* Home Page
* The home page of the Profile Card demo.
* @author : F-O
*/

# Including all the required scripts for demo
require __DIR__ . "/php/discord.php";
require __DIR__ . "/php/config.php";
?>
<!DOCTYPE html>
<html lang="pl-PL">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KZK Bielki - Logowanie</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="https://kit.fontawesome.com/7535758241.js" crossorigin="anonymous"></script>
</head>
<body>
    <div style="display: flex;align-items: center;height: 100vh;">
        <div class="section w-30 mx-auto bp-m">
            <img src="img/kzk_red_text.png" alt="logo kzk" style="height:10rem;display:block;margin:auto;">
            <form class="d-block mx-auto w-60">
                <a class="btn danger mx-auto d-block ta-center" href="<?=$auth_url = url($client_id, $redirect_url, $scopes)?>">Zaloguj się przez Discord <i class='fa-brands fa-discord'></i></a>
            </form>
        </div>
    </div>
</body>
</html>