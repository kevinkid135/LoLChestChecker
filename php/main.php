<!doctype html>

<html lang="en">
<head>
	<meta charset="utf-8">

	<title>Check Mastery Chest</title>
	<!--[if lt IE 9]>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
	<![endif]-->
</head>

<body>
<?php
	include 'riotapi.php';
	$summName = $_GET["summName"];
	$region = $_GET["region"];
	$summID = getSummID($region, $summName);

	// ign and id
	echo "IGN: " . $summName;
	echo "\n<br>\n";
	echo "Your summoner ID is: " . $summID;
?>
<br>
<!-- select champion -->
<?php
$champList = getChampList_NAME($region);

// getChampID($region, 'vi');

// print array
foreach ($champList as $c){
	echo $c;
	echo "<br>";
}

?>
</body>
</html>