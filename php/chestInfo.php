<!doctype html>

<html lang="en">
<head>
    <meta charset="utf-8">

    <title>Check Mastery Chest</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="../css/chestInfo.css">
</head>

<body>
<header>
    <div id="headerBox">

        <div id="summInfo">
            <?php
            include 'riotAPI.php';
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

            // these variables
            $summId = $summInfo['id'];
            $summName = $summInfo['name'];
            $accId = $summInfo['accountId'];
            ?>

            <img src="<?php echo getSummonerIcon($version, $summInfo['profileIconId']) ?>"
                 alt="Profile Icon <?php echo $summInfo['profileIconId'] ?>" id="profileIcon"
                 class="img-rounded portrait">

            <div id="profileInfo">
                <dl class="dl-horizontal">
                    <dt id="ign">Summ Name</dt>
                    <dd>
                        <div id="input-field">
                            <form class="form-inline" action="chestInfo.php" method="GET">

                                <div class="form-group">
                                    <label for="summName" class="sr-only">Summoner Name</label>
                                    <input type="text" name="summName" class="form-control"
                                           value="<?php echo $summName ?>"
                                           placeholder="Summoner Name"
                                           id="summName" required>
                                </div>

                                <div class="form-group">
                                    <label for="region" class="sr-only">Region</label>
                                    <select name="region" class="btn btn-default" id="region">
                                        <option value="na">NA</option>
                                        <!-- Find out how to: Sort alphabetically, but will cache old selection using cookies -->
                                        <option value="br">BR</option>
                                        <option value="eune">EUNE</option>
                                        <option value="euw">EUW</option>
                                        <option value="jp">JP</option>
                                        <option value="kr">KR</option>
                                        <option value="lan">LAN</option>
                                        <option value="las">LAS</option>
                                        <option value="oce">OCE</option>
                                        <option value="ru">RU</option>
                                        <option value="tr">TR</option>
                                    </select>
                                </div>
                                <input type="submit" value="Search" class="btn btn-default" id="summSearch"/>
                            </form>
                        </div>
                    </dd>
                    <dt>Summ ID</dt>
                    <dd><?php echo $summId ?></dd>
                    <dt>Account ID</dt>
                    <dd><?php echo $accId ?></dd>
                    <dt>FWOTD</dt>
                    <dd>
                    <span id="fwotd">
                    <?php
                    //$t = fwotdTime($region, $accId) - time();
                    if (true) { // TODO figure out a way to calculate FWOTD
                        echo "Functionality cannot be calculated anymore due to API changes... Sorry :(";
                    } else if ($t <= 0) {
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
                    <dt>Prev Win</dt>
                    <dd>
                        <?php
                        $milliseconds = fwotdTime($region, $accId);

                        echo date("m-d-Y h:i:sa", $milliseconds / 1000) . " " . date_default_timezone_get();;
                        ?>
                    </dd>
                </dl>
                <button class="btn btn-info" id="renew-btn"
                        onclick="renew(<?php echo "'" . $region . "'" ?>, <?php echo $summId ?>)">
                    Recheck FWOTD
                </button>
            </div>
        </div>
        <div id="search">
            <!-- search by champion name -->
            <input id="champSearch" class="form-control" type="text" oninput="searchPortraits()"
                   placeholder="Search champion name">
        </div>
    </div>

</header>
<section>
    <div class="container" id="portrait-list">
        <!-- Show all champions -->
        <?php
        $masteryList = getChampMasteryList_ARRAY($region, $summId);
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
            // sort by key
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
            // anonymous function to sort based on chestGranted
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
    <p>LoLcc isn't endorsed by Riot Games and doesn't reflect the views or opinions of Riot
        Games or anyone officially involved in producing or managing League of Legends. League of Legends and Riot Games
        are trademarks or registered trademarks of Riot Games, Inc. League of Legends © Riot Games, Inc.</p>
</footer>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script type="text/javascript" src="../js/chestInfo.js"></script>
<!-- Start of StatCounter Code for Default Guide -->
<script type="text/javascript">
    var sc_project = 11205072;
    var sc_invisible = 1;
    var sc_security = "852b1dc0";
    var scJsHost = (("https:" == document.location.protocol) ?
        "https://secure." : "http://www.");
    document.write("<sc" + "ript type='text/javascript' src='" +
        scJsHost +
        "statcounter.com/counter/counter.js'></" + "script>");
</script>
<noscript>
    <div class="statcounter"><a title="free hit
counter" href="http://statcounter.com/" target="_blank"><img
                    class="statcounter"
                    src="//c.statcounter.com/11205072/0/852b1dc0/1/" alt="free
hit counter"></a></div>
</noscript>
<!-- End of StatCounter Code for Default Guide -->
</body>
</html>