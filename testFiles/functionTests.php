<!doctype html>
<html lang="en">

<head>
    <link rel="stylesheet" href="testStyle.css">
</head>
<body>
<div id="mainDiv">
    <?php
    $summID = 23240236;
    $region = 'NA';
    ?>

    <h1>Test each function:</h1>
    <h2>Testing Static Functions:</h2>
    <?php
    include '../php/riotapi.php';
    ?>

    <h3>Testing: getCurrentVersion</h3>
    <div class="section">
        <?php
        $result = getCurrentVersion($region);
        echo $result;
        ?>
    </div>

    <h3>Testing: getChampListByKey</h3>
    <div class="section">
        <?php
        $arr = getChampListByKey($region);
        var_dump($arr);
        ?>
    </div>

    <h3>Testing: getChampListById</h3>
    <div class="section">
        <?php
        $arr = getChampListById($region);
        var_dump($arr);
        ?>
    </div>

    <h3>Testing: getChampName</h3>
    <div class="section">
        <?php
        $name = getChampName($region, 5);
        echo $name;
        ?>
    </div>

    <h3>Testing: getChampID</h3>
    <div class="section">
        <?php
        $ID = getChampID($region, 'XinZhao');
        echo $ID;
        ?>
    </div>

    <h3>Testing: getChampInfo_ARRAY</h3>
    <div class="section">
        <?php
        $arr = getChampInfo_ARRAY($region, 254);
        var_dump($arr);
        ?>
    </div>

    <br>
    <hr>
    <h2>Testing Riot API (non-static)</h2>

    <h3>Testing: getChampMasteryList_ARRAY</h3>
    <div class="section">
        <?php
        $arr = getChampMasteryList_ARRAY($region, $summID);
        var_dump($arr);
        ?>
    </div>

    <h3>Testing: getSumm_ARRAY</h3>
    <div class="section">
        <h3>Kirox3</h3>
        <?php
        $arr = getSumm_ARRAY($region, 'Kirox3');
        var_dump($arr);
        ?>

        <h3>ComfyCongee</h3>
        <?php
        $arr = getSumm_ARRAY($region, 'ComfyCongee');
        var_dump($arr);
        ?>

        <h3>Korean Letters</h3>
        <?php
        $arr = getSumm_ARRAY($region, '잘못');
        var_dump($arr);
        ?>

        <h3>Spaces</h3>
        <?php
        $arr = getSumm_ARRAY($region, 'the best');
        var_dump($arr);
        ?>

        <h3>TR</h3>
        <?php
        $arr = getSumm_ARRAY('tr', 'CJ Ghost');
        var_dump($arr);
        ?>

        <h3>RU</h3>
        <?php
        $arr = getSumm_ARRAY('ru', 'Tetrael');
        var_dump($arr);
        ?>

        <h3>EUNE</h3>
        <?php
        $arr = getSumm_ARRAY('eune', 'Adben');
        var_dump($arr);
        ?>
    </div>

    <h3>Testing: getRecentGames</h3>
    <div class="section">
        <?php
        $arr = getRecentGames($region, 54392217);
        var_dump($arr);
        ?>
    </div>

    <h3>Testing: fwotdTime</h3>
    <div class="section">
        <?php
        $result = fwotdTime($region, $summID);
        echo $result;
        ?>
    </div>

</div>
<script>
    // scroll to bottom of the page
    window.scrollTo(0, document.body.scrollHeight);
</script>
</body>
</html>
