<?php
/**
 * Created by PhpStorm.
 * User: michi
 * Date: 9-5-2018
 * Time: 13:38
 */

require_once ("scripts/database.php");/* database */

if(isset($_GET["idsong"])){
    $SQL = "INSERT INTO savedsongs(songid) VALUES (?)";

    $stmt = $mysqli->prepare($SQL);
    $stmt->bind_param("i",$id);
    $id = $_GET["idsong"];
    $stmt->execute();
    }

header("Location:song.php")
?>