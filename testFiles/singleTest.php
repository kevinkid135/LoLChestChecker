<!doctype html>
<html lang="en">

<head>
    <link rel="stylesheet" href="testStyle.css">
</head>
<body>
<?php
include '../php/riotapi.php';
?>
<form name="summNameForm" action="test2.php" method="GET">
    <input type="text" name="summName" placeholder="Summoner Name" autofocus="autofocus" required>
    <input type="submit" value="Search"/>
</form>

<div class="section">
    <?php
    $summID = 23240236;
    $recentGames = getRecentGames('NA', $summID);
    var_dump($recentGames);
    ?>
</div>

<div class="section">
    <?php
    function timeUntilFwotd($region, $summID) {
        return gmdate('H:i:s', fwotdTime($region, $summID) - time());
    }
    ?>
</div>
</body>