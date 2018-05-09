<?php
require_once("scripts/database.php");
require_once("scripts/helpfunctie.php");

$sqlLijstPlayst = "SELECT playlistid, titel
FROM savedplaylist s INNER JOIN playlist p ON s.playlistid = p.idplaylist";


$sqlInhoud = "SELECT s.idsongs, s.title,s.duur, a.naam, cd.cdtitel, ss.date as toegevoegd
FROM  savedsongs ss INNER JOIN song s ON ss.songid = s.idsongs INNER JOIN artiest a ON s.artistid = a.idartiest 
INNER JOIN songopcd soc ON s.idsongs = soc.songid INNER JOIN cd ON soc.cdid = cd.idcd";


//voor NAV
if (!$resNAVPlayst = $mysqli->query($sqlLijstPlayst)) {
    echo "oeps, foutje op db";
    print("<p>Error: " . $mysqli->error . "</p>");
    exit();
}
if (isset($_GET["idplaylist"])) {
    $gekozenID = $_GET["idplaylist"];
} else {
    $gekozenID = -1;
}

//Voor inhoud
$stmtInhoud = $mysqli->prepare($sqlInhoud);
//$stmtInhoud->bind_param("i", $par3);
//$par3 = $gekozenID;
$stmtInhoud->execute();
$resultInhoud = $stmtInhoud->get_result();
//Omdat we nu verschillende rijen terugkrijgen nog geen fetch, maar een lus starten
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mitify</title>


    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css"
          integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css"
          integrity="sha384-3AB7yXWz4OeoZcPbieVW64vVXEwADiYyAEhwilzWsLw+9FgqpyjjStpPnpBO8o8S" crossorigin="anonymous">


    <link rel="stylesheet" href="css/screen.css">
</head>
<body class="container-fluid">

<div class=" row h-100" id="container">
    <aside class="col-2">
        <nav>
            <ul class="list-unstyled">

                <li><a href="#">Browse</a></li>
                <li><a href="#">Radio</a></li>
            </ul>

        </nav>
        <nav>
            <h1>your Library</h1>
            <ul class="list-unstyled">

                <li><a href="#">Your daily mix</a></li>
                <li><a href="#">Recent played</a></li>
                <li><a href="#">Songs</a></li>
                <li><a href="#">Albums</a></li>
                <li><a href="#">Artists</a></li>
                <li><a href="#">Stations</a></li>

            </ul>


        </nav>
        <nav>
            <h1>Playlists</h1>
            <!--<ul class="list-unstyled">
                <li><a href="#">Playlist 1</a></li>
                <li><a href="#">Playlist 2</a></li>
                <li class="active"><a href="#">Playlist 3</a></li>
                <li><a href="#">Playlist 4</a></li>
                <li><a href="#">Playlist 5</a></li>
                <li><a href="#">Playlist 6</a></li>
            </ul>-->
            <?php
            while ($row = $resNAVPlayst->fetch_assoc()) {
                $tempID = $row["playlistid"]; //rijen uit sql
                $tempTitel = $row["titel"]; //rijen uit sql
                if ($tempID == $gekozenID) {
                    print(' <li class="active"><a href="playlist.php?idplaylist=' . $tempID . '">' . $tempTitel . '</a></li>');
                } else {
                    print(' <li><a href="playlist.php?idplaylist=' . $tempID . '">' . $tempTitel . '</a></li>');
                }

            }
            ?>
        </nav>

    </aside>
    <main class=" col-10">
        <header class="row">
            <div class="col-6 ">
                <a href="#"><i class="fas fa-chevron-left"></i></a>
                <a href="#"><i class="fas fa-chevron-right"></i></a>
                <input type="text" name="zoek" id="zoek">


            </div>
            <div class="col-6 text-right">
                <img src="images/playlist/person.png" alt="gebruiker">
                <span>vnaam Fnaam</span>
                <span>
                    <a href="#"><i class="fas fa-chevron-down"></i></a>
                </span>


            </div>
        </header>
        <section class="row " id="content">
            <header class="col-12">
                <div class="row">
                    <div class="d-none col-md-3 col-lg-2 d-md-block" id="content_cover">

                    </div>
                    <div class="col-md-9 col-lg-10">
                        <div class="type">Saved Songs</div>

                    </div>
                    <div class="col-sm-6 actions">
                        <a href="#" class="btn solid" role="button">Play</a>


                    </div>
                    <div class="col-sm-6 followers text-right">

                    </div>

                </div>
            </header>
            <div class="col-12 scrolledsmall">

                <div class="row ">
                    <div class="d-none col-1 content_cover">

                    </div>
                    <div class="col-6 content_info">
                        <h1>Saved Songs </h1>
                    </div>

                    <div class="col-5 actions content_actions text-right">
                        <a class="btn" href="#" role="button">Play</a>

                    </div>

                </div>


            </div>
            <section class="col-12" id="bevat">
                <div class="row tabelview">
                    <table class="table">
                        <thead>
                        <tr>
                            <th></th>
                            <th></th>
                            <th>title</th>
                            <th>artist</th>
                            <th>album</th>
                            <th><i class="far fa-calendar"></i></th>
                            <th></th>
                            <th><i class="far fa-clock"></i></th>
                        </tr>

                        </thead>
                        <tbody>
                        <?php
                        while ($row = $resultInhoud->fetch_assoc()) {
                            print('<tr>');
                            print('<td class="play_status"><i class="fas fa-volume-up"></i> <i class="far fa-play-circle"></i><i class="far fa-pause-circle"></i></td>');
                            print('<td><a href="songs_save.php?idsong=' . $row["idsongs"] . '"><i class="fas fa-plus"></i></a></td>');
                            print('<td>' . $row["title"] . '</td>');
                            print('<td>' . $row["naam"] . '</td>');
                            print('<td>' . $row["cdtitel"] . '</td>');
                            print('<td>' . $row["toegevoegd"] . '</td>');
                            print('<td><i class="fas fa-ellipsis-h"></i></td>');
                            print('<td>' . sec_naar_tijd($row["duur"]) . '</td>');
                            print('</tr>');
                        }
                        ?>


                        </tbody>
                    </table>


                </div>
            </section>
        </section>


    </main>
</div>

<footer class="row fixed-bottom ">
    <section class="col-3" id="now_playing">
        <div class="row no-gutters">
            <div class="col-4 album_playing">
                <img src="images/playlist/placeholder.png" class="img-fluid">
                <div class="album_open_btn">
                    <i class="fas fa-chevron-up albumup" id=""></i>
                </div>
            </div>
            <div class="col-8 m-auto">
                <section class="infoplaying">
                    <div class="songtitle">
                        <a href="#">Title</a>
                        <a href="#"><i class="fas fa-plus"></i></a>
                    </div>
                    <div class="artiest">
                        <a href="#">artiest</a>
                    </div>
                </section>
            </div>
        </div>
    </section>
    <section class="col-6 m-auto" id="now_ctrl">
        <div class="text-center">
            <i class="fas fa-random"></i>
            <i class="fas fa-step-backward"></i>
            <i class="fa-2x far fa-play-circle"></i>
            <i class="fas fa-step-forward"></i>
            <i class="fas fa-redo-alt"></i>
        </div>

        <div class="row">
            <div class="col-3 text-center">x:xx</div>
            <div class="col-6 m-auto">
                <div class="playbar">
                    <div class="currentposbar"></div>
                    <div class="currentpos"></div>
                </div>
            </div>
            <div class="col-3 text-center">x:xx</div>
        </div>
    </section>
    <section class="col-3 m-auto" id="now_remote">
        <div class="row">
            <div class="col-3 text-center">
                <i class="fas fa-list-ul"></i>
                <i class="fas fa-desktop"></i>
                <i class="fas fa-volume-up"></i></div>
            <div class="col-6 m-auto">
                <div class="playbar">
                    <div class="currentposbar"></div>
                    <div class="currentpos"></div>
                </div>
            </div>
            <div class="col-3 text-center">
                <i class="fas fa-expand"></i>
            </div>
        </div>
    </section>
</footer>


<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="scripts/checkscroll.js?blablabla"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js"
        integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1"
        crossorigin="anonymous"></script>
</body>
</html>