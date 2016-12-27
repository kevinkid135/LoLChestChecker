<!doctype html>

<html lang="en">
<head>
    <meta charset="utf-8">

    <title>Check Mastery Chest</title>

    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="../css/chestInfo.css">


    <script type="text/javascript" src="../js/cssrefresh.js"></script>
</head>

<body>
<header class="container">
    <div id="summInfo">
        <?php
        include 'riotapi.php';
        global $regionList;
        $region = $_GET["region"];
        $summName = $_GET["summName"];
        $version = getCurrentVersion($region);

        // client side check for error in summoner name and region
        if (preg_match("/^[0-9\p{L} .]+$/u", $summName) && !in_array($region, $regionList)) {
            header("Location: errorPage.php");
            exit();
        }

        $summInfo = getSumm_ARRAY($region, $summName); // get summoner ID based off summoner name
        // server sided check for error in summName
        if (count($summInfo) == 2) {
            header("Location: errorPage.php");
            exit();
        }
        $summID = $summInfo['id'];
        $summName = $summInfo['name'];
        ?>

        <img src="<?php echo getSummonerIcon($version, $summInfo['profileIconId']) ?>"
             alt="Profile Icon <?php echo $summInfo['profileIconId'] ?>" id="profileIcon" class="img-rounded portrait">
        <div id="profileInfo">
            <dl class="dl-horizontal">
                <dt>IGN</dt>
                <dd><?php echo $summName ?></dd>
                <dt>Summ ID</dt>
                <dd><?php echo $summID ?></dd>
                <dt>FWOTD</dt>
                <dd>
                    <?php
                    $t = fwotdTime($region, $summID) - time();
                    if ($t <= 0) {
                        echo "Available";
                    } else {
                        $hr = gmdate('G', $t);
                        $min = intval(gmdate('i', $t));
                        if ($hr == 0) {
                            // only display minutes
                            echo $min . 'm remaining';
                        } else {
                            echo $hr . 'h ' . $min . 'm remaining';
                        }
                    }
                    ?>
                </dd>
            </dl>
        </div>
    </div>

    <!-- TODO Search area -->
    <div>

    </div>
</header>
<div class="container portrait-list">
    <!-- Show all champions -->
    <?php
    $masteryList = getChampMasteryList_ARRAY($region, $summID);


    $champListArray = getChampListById($region);
    /*
     * masterArray will have:
     * championId => array(id, key, name, chestGranted, championPoints)
     */
    $masterArray = $champListArray;
    foreach ($masterArray as $id => $arr) {
        unset($masterArray[$id]['title']);
        $masterArray[$id]['chestGranted'] = false;
        $masterArray[$id]['championPoints'] = 0;
    }

    // check if there were any errors getting list
    if (!isset($masteryList[0]['status_code'])) {
        foreach ($masteryList as $champArr) {
            $masterArray[$champArr['championId']]['chestGranted'] = $champArr['chestGranted'];
            $masterArray[$champArr['championId']]['championPoints'] = $champArr['championPoints'];
        }
    }

    //sort based on chestGranted
    uasort($masterArray, function ($a, $b) {
        // sort based on chest Granted
        if ($a['chestGranted'] && !$b['chestGranted']) {
            return -1;
        } elseif (!$a['chestGranted'] && $b['chestGranted']) {
            return 1;
        } else {
            // sort based on name
            if ($a['name'] < $b['name']) {
                return -1;
            } else {
                return 1;
            }
        }
    });

    foreach ($masterArray as $champArr) {
        echo '<div class="hoverWrap">';

        echo '<img src="' . getChampPortrait($version, $champArr['key']) . '" alt="' . $champArr['name'] . ' Portrait" class="portrait ';
        if ($champArr['chestGranted']) {
            echo 'granted">';
        } else {
            echo 'notGranted">';
        }
        echo '<span class="championPoints">' . $champArr['championPoints'] . '</span>';

        echo "</div>\r\n";
    }
    ?>
</div>
</body>
</html>