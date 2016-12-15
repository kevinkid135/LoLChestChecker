<!doctype html>
<html lang="en">

<head>
    <link rel="stylesheet" href="testStyle.css">
</head>
<body>
<?php
include '../php/riotapi.php';
?>
<h2>Testing: getChampListImages_ARRAY</h2>
<div class="section">
    <?php
    $result = getChampListImages_ARRAY('NA');
    var_dump($result);
    //    echo $result;
    ?>
</div>
</body>