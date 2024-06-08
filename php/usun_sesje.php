<?php
    session_start();
    $conn = new mysqli("localhost","root","","y4ch0");
    $conn->set_charset("utf8");
    $uid = $_SESSION['user_id'];
    $sesjaId = $_POST['sesja_id'];
    $validation1 = $conn->query("SELECT id FROM sesje WHERE sesje.id = $sesjaId AND sesje.hostId = (SELECT id FROM konta WHERE konta.id = '$uid')");
    if($validation1->num_rows == 1) {
        $shiftInfoQuery = $conn->query("SELECT dataSesji,godzinaRozpoczecia,konta.id FROM sesje,konta WHERE konta.id = sesje.hostId AND konta.id = (SELECT id FROM konta WHERE id = '$uid') AND sesje.id = '$sesjaId'");
        $row = $shiftInfoQuery->fetch_row();
        $deleteQuery = "UPDATE sesje SET hostId = NULL WHERE sesje.id = $sesjaId AND sesje.hostId = (SELECT id FROM konta WHERE konta.id = '$uid')";
        if(!$conn->query($deleteQuery)) {
            include("../sesje.php");
            echo "
                <h3>Wystąpił błąd podczas usuwania sesji.</h3>
            ";
        } else {
            if(isset($_POST['cancelBtn'])) {
                $webhookurl = "https://discord.com/api/webhooks/1196038204483178537/rs8krn1Y8YMj0TyB_uw5J9yqLDZOH-U_kDrCKKhdmOGw9tUMAh2GiqojUg9uDfxAAFjz";
                $timestamp = date("c", strtotime("now"));
                $json_data = json_encode([
                    // Message
                    "content" => "@everyone",
                    // Username
                    "username" => "KZK Bielki Shift Assistant",
                    // Avatar URL.
                    // Uncoment to replace image set in webhook
                    "avatar_url" => "https://cdn.discordapp.com/icons/988151388888518796/a_1c246c98ce29651a215f4fa596ed7398.gif?size=4096",
                    // Text-to-speech
                    "tts" => false,
                    // File upload
                    // "file" => "",
                    // Embeds Array
                    "embeds" => [
                        [
                            // Embed Title
                            "title" => "Shift that was planned at <t:".strtotime($row[0]." ".$row[1]).":F> has been cancelled",
                            // Embed Type
                            "type" => "rich",
                            // Embed Description
                            "description" => "The shift host was <@".$row[2].">",
                            // URL of title link
                            //"url" => "https://gist.github.com/Mo45/cb0813cb8a6ebcd6524f6a36d4f8862c",
                            // Timestamp of embed must be formatted as ISO8601
                            "timestamp" => $timestamp,
                            // Embed left border color in HEX
                            "color" => hexdec("c60000"),
                            // Footer
                            /*"footer" => [
                                "text" => "GitHub.com/Mo45",
                                "icon_url" => "https://ru.gravatar.com/userimage/28503754/1168e2bddca84fec2a63addb348c571d.jpg?size=375"
                            ],*/
                        ]
                    ]
                ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
                $ch = curl_init( $webhookurl );
                curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
                curl_setopt( $ch, CURLOPT_POST, 1);
                curl_setopt( $ch, CURLOPT_POSTFIELDS, $json_data);
                curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
                curl_setopt( $ch, CURLOPT_HEADER, 0);
                curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
                $response = curl_exec( $ch );
                // If you need to debug, or find out why you can't send message uncomment line below, and execute script.
                // echo $response;
                curl_close( $ch );
            }
            header("location:../sesje.php");
        }
    };
?>