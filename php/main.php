<!doctype html>

<html lang="en">
<head>
    <meta charset="utf-8">

    <title>Check Mastery Chest</title>
</head>

<body>
<?php
include 'riotapi.php';
$summName = $_GET["summName"];
$region = $_GET["region"];
$summID = getSumm_ARRAY($region, $summName)['id'];

// ign and id
echo "IGN: " . $summName;
echo "\n<br>\n";
echo "Your summoner ID is: " . $summID;
?>
<br>
<!-- Show all champions -->
<?php
$champMasteryList = getChampMasteryList_ARRAY($region, $summID);
foreach ($champMasteryList as $key => $arr) {
    // TODO figure out how to get champion names faster.
    // Not only does this take more than one minute to complete, it makes a lot of calls to riot API
    // echo getChampName($region, $arr['championId']);
    echo $arr['championId'];
    echo " : ";
    if ($arr['chestGranted'] == 1) {
        echo 'true';
    } else {
        echo 'false';
    }
    echo '<br>';
}
?>
</body>
</html>