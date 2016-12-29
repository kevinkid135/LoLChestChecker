<!doctype html>

<html lang="en">
<head>
    <meta charset="utf-8">

    <title>Check Mastery Chest</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="../css/chestInfo.css">

    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>


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
                <dt id="ign">Summ Name</dt>
                <dd>
                    <div id="input-field">
                        <form class="form-inline" action="chestInfo.php" method="GET">

                            <div class="form-group">
                                <label for="summName" class="sr-only">Summoner Name</label>
                                <input type="text" name="summName" class="form-control" value="<?php echo $summName ?>"
                                       placeholder="Summoner Name"
                                       id="summName" required>
                            </div>

                            <div class="form-group">
                                <label for="region" class="sr-only">Region</label>
                                <select name="region" class="btn btn-default" id="region">
                                    <option value="NA">NA</option>
                                    <!-- Find out how to: Sort alphabetically, but will cache old selection -->
                                    <option value="BR">BR</option>
                                    <option value="EUNE">EUNE</option>
                                    <option value="EUW">EUW</option>
                                    <option value="JP">JP</option>
                                    <option value="KR">KR</option>
                                    <option value="LAN">LAN</option>
                                    <option value="LAS">LAS</option>
                                    <option value="OCE">OCE</option>
                                    <option value="RU">RU</option>
                                    <option value="TR">TR</option>
                                </select>
                            </div>
                            <input type="submit" value="Search" class="btn btn-default" id="summSearch"/>
                        </form>
                    </div>
                </dd>
                <dt>Summ ID</dt>
                <dd><?php echo $summID ?></dd>
                <dt>FWOTD</dt>
                <dd>
                    <span id="fwotd">
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
                    </span>
                </dd>
                <dt></dt>
            </dl>
            <button class="btn btn-info" id="renew-btn"
                    onclick="renew(<?php echo "'" . $region . "'" ?>, <?php echo $summID ?>)">
                Recheck FWOTD
            </button>
        </div>
    </div>

    <!-- TODO sort by different attributes using radio buttons: name, champPoints; ascending, descending; lastPlayed -->
    <!-- TODO show only: chestGranted, chestNotGranted, championWithZeroPoints, champWithMoreThanZeroPts -->
    <!-- search by champion name -->
    <input id="champSearch" type="text" oninput="reloadPortraits()" placeholder="Search by champion name">

</header>
<section>
    <div class="container" id="portrait-list">
        <!-- Show all champions -->
        <?php
        $masteryList = getChampMasteryList_ARRAY($region, $summID);
        $champListArray = getChampListById($region);

        /*
         * masterArray will have:
         * championId => array(id, key, name, chestGranted, championPoints)
         */
        //insert id, key, name
        $masterArrayById = $champListArray;

        // chestGranted and championpoints keys inserted
        foreach ($masterArrayById as $id => $arr) {
            unset($masterArrayById[$id]['title']);
            $masterArrayById[$id]['chestGranted'] = false;
            $masterArrayById[$id]['championPoints'] = 0;
        }


        // check if there were any errors getting list
        if (!isset($masteryList[0]['status_code'])) {
            foreach ($masteryList as $champArr) {
                // insert appropriate chestGranted and champ points into array
                $masterArrayById[$champArr['championId']]['chestGranted'] = $champArr['chestGranted'];
                $masterArrayById[$champArr['championId']]['championPoints'] = $champArr['championPoints'];
            }
        }

        ?>
        <script>
            <?php
            $masterArrayByKey = array();
            foreach ($masterArrayById as $arr) {
                $masterArrayByKey[$arr['key']] = $arr;
            }
            ?>
            //export array to JSON
            var masterArray = <?php echo json_encode($masterArrayByKey, JSON_FORCE_OBJECT)?>;
        </script>

        <?php
        //sort based on chestGranted
        uasort($masterArrayById, function ($a, $b) {
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

        // add hover text
        foreach ($masterArrayById as $champArr) {
            echo '<div class="hoverWrap" id="' . $champArr['key'] . '">';

            echo '<img src="' . getChampPortrait($version, $champArr['key']) . '" alt="' . $champArr['name'] . ' Portrait" class="portrait ';
            if ($champArr['chestGranted']) {
                echo 'granted">';
            } else {
                echo 'notGranted">';
            }
            echo '<span class="championPoints">' . $champArr['championPoints'] . '</span>';
            echo '<span class="champName">' . $champArr['name'] . '</span>';
            echo "</div>\r\n";
        }
        ?>
    </div>
</section>
<footer>
    <h2>Title</h2>
    <p>Placeholder Text</p>
</footer>
</body>
<script type="text/javascript" src="../js/chestInfo.js"></script>
<script type="text/javascript" src="../js/cssrefresh.js"></script>
</html>