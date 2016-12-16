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
    foreach ($result as $link) {
        echo '<img src="' . $link . '" alt="Champion Image" style="margin:5px;height:100px;width:100px">';
    }
    //    echo $result;
    ?>
</div>
</body>