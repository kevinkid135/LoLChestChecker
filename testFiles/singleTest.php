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

<p>
    <?php
    $a = 'a';
    $b = 'b';
    if ($a > $b) {
        echo $a . " is greater than " . $b;
    } elseif ($a < $b) {
        echo $a . " is less than " . $b;
    } else {
        echo 'idk';
    }
    ?>
</p>
</body>