<?php
$summName = $_GET["summName"];

if (preg_match("/^[0-9\p{L} .]+$/", $summName)) {
    echo "valid summoner name";
} else {
    echo "invalid";
}