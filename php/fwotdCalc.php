<?php
/**
 * Created by PhpStorm.
 * User: Kevin
 * Date: 12/27/2016
 * Time: 08:41 PM
 */

$region = $_GET["region"];
$summID = $_GET["summID"];

include 'riotAPI.php';
$t = fwotdTime($region, $summID) - time();
if ($t <= 0) {
    echo "Available";
} else {
    $hr = gmdate('G', $t);
    $min = intval(gmdate('i', $t));
    if ($hr == 0) {
        // only display minutes
        echo $min . 'm remaining';
    } else {
        echo $hr . 'h ' . $min . 'm remaining';
    }
}