<!doctype html>

<html lang="en">
<head>
    <meta charset="utf-8">

    <title>Check Mastery Chest</title>
    <link rel="stylesheet" href="../css/main.css">
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
$champListId_key = getChampList_KEY($region);
$champMasteryList = getChampMasteryList_ARRAY($region, $summID);
$version = getCurrentVersion($region);
foreach ($champMasteryList as $arr) {
    $link = getChampPortrait($champListId_key[$arr['championId']], $version);
    if ($arr['chestGranted'] == 1) {
        echo '<img src="' . $link . '" alt="Champion Image" style="border-color:green">';
    } else {
        echo '<img src="' . $link . '" alt="Champion Image" style="border-color:red">';
    }
}
?>
</body>
</html>