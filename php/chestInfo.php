<!doctype html>

<html lang="en">
<head>
    <meta charset="utf-8">

    <title>Check Mastery Chest</title>
    <link rel="stylesheet" href="../css/chestInfo.css">
</head>

<body>
<?php
include 'riotapi.php';
global $regionList;
$region = $_GET["region"];
$summName = $_GET["summName"];

// client side check for error in summoner name and region
if (preg_match("/^[0-9\p{L} .]+$/u", $summName) && !in_array($region, $regionList)) {
    header("Location: errorPage.php");
    exit();
}

$summID = getSumm_ARRAY($region, $summName); // get summoner ID based off summoner name
// server sided check for error in summName
if (count($summID) == 2) {
    header("Location: errorPage.php");
    exit();
}
$summID = $summID['id'];

// ign and id
echo "IGN: " . $summName;
echo "\n<br>\n";
echo "Your summoner ID is: " . $summID;
?>
<br>

<!-- Show all champions -->
<?php
$masteryList = getChampMasteryList_ARRAY($region, $summID);
$champListArray = getChampListById($region);
/*
 * masterArray will have:
 * championId => array(id, key, name, chestGranted)
 */
$masterArray = $champListArray;
foreach ($masterArray as $id => $arr) {
    unset($masterArray[$id]['title']);
    $masterArray[$id]['chestGranted'] = false;
}

foreach ($masteryList as $champArr) {
    $masterArray[$champArr['championId']]['chestGranted'] = $champArr['chestGranted'];
}

//var_dump($masterArray);

//sort based on chestGranted
uasort($masterArray, function ($a, $b) {
    // sort based on chest Granted
    if ($a['chestGranted'] && !$b['chestGranted']) {
        return -1;
    } elseif (!$a['chestGranted'] && $b['chestGranted']) {
        return 1;
    }

    // sort based on name
    if ($a['name'] < $b['name']) {
        return -1;
    } else {
        return 1;
    }

});

$version = getCurrentVersion($region);
foreach ($masterArray as $champArr) {
    if ($champArr['chestGranted']) {
        echo '<img src="' . getChampPortrait($champArr['key'], $version) . '" alt="Champion Portrait" class="granted">';
    } else {
        echo '<img src="' . getChampPortrait($champArr['key'], $version) . '" alt="Champion Portrait" class="notGranted">';
    }
}
?>
</body>
</html>