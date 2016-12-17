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
$summID = getSumm_ARRAY($region, $summName);
// check for error in region or summoner name.
if (count($summID) == 2 || !in_array($region, $regionList)) {
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
$champListId_key = getChampList_KEY($region);
$champMasteryList = getChampMasteryList_ARRAY($region, $summID);
$version = getCurrentVersion($region);
foreach ($champMasteryList as $arr) {
    $link = getChampPortrait($champListId_key[$arr['championId']], $version);
    if ($arr['chestGranted'] == 1) {
        echo '<img src="' . $link . '" alt="Champion Portrait" class="granted">';
    } else {
        echo '<img src="' . $link . '" alt="Champion Portrait" class="notGranted">';
    }
}
?>
</body>
</html>