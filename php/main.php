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
<!-- select champion -->
<?php
$test = getChampID($region, 'Vi');
$test = getChampInfo_ARRAY($region, $test);
// $test = getChampList_ARRAY($region);
var_dump($test);
?>
</body>
</html>