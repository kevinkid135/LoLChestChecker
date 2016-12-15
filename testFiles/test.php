<!doctype html>
<html lang="en">

<head>
    <link rel="stylesheet" href="testStyle.css">
</head>
<body>
<?php
include '../php/riotapi.php';
?>
<h2>Testing: getChampName</h2>
<div class="section">
    <?php
    $arr = getChampName('NA', 5);
    var_dump($arr);
    ?>
</div>
</body>