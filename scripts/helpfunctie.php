<?php
/**
 * Created by PhpStorm.
 * User: michi
 * Date: 3-5-2018
 * Time: 14:54
 */

function sec_naar_tijd($aantalSec){
    $hour = floor($aantalSec / 3600);
    $resterendeSecondenNaUur = $aantalSec % 3600;
    $minutes = floor($resterendeSecondenNaUur /60);
    $resterendeSecondenNaMinuten = $resterendeSecondenNaUur %60;
    if ($hour > 0){
        return $hour  . ' h ' . $minutes . ' min';
    }else{
        return $minutes . ' min ' . $resterendeSecondenNaMinuten . ' sec';
    }
}
?>