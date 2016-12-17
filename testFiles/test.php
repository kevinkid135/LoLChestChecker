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
</body>