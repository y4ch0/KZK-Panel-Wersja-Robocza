<?php

/* Discord Oauth v.4.1
 * Demo Login Script
 * @author : MarkisDev
 * @copyright : https://markis.dev
 */

# Including all the required scripts for demo
session_start();

require __DIR__ . "/discord.php";
require "config.php";
require "dziennik_zdarzen/dodaj.php";

# Initializing all the required values for the script to work
init($redirect_url, $client_id, $secret_id, $bot_token);

# Fetching user details | (identify scope)
get_user();
$conn = new mysqli("81.171.31.232","y4ch0_03032006","Polkij11!","y4ch0");
$conn->set_charset("utf8");
$uid = $_SESSION['user_id'];
$result = $conn->query("SELECT id FROM konta WHERE konta.id = '$uid'");
if($result->num_rows < 1 || $result->num_rows > 1 ) {
    header("location:logout.php");
}

# Redirecting to home page once all data has been fetched
dodajWiersz($uid,"Zalogował się");
header('Location: ../');
exit;