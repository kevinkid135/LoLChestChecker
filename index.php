<!doctype html>

<html lang="en">
<head>
    <meta charset="utf-8">

    <title>LoL Chest Checker</title>

    <!-- CSS Files-->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/index.css">

    <!-- JS Files-->
    <script type="text/javascript" src="js/cssrefresh.js"></script>
</head>

<body>

<header>
    <h1>League of Legends Chest Checker</h1>
</header>

<section>
    <img src="img/Hextech_Crafting.jpg" id="chest-img">
    <div id="input-field">
        <form class="form-inline" action="php/chestInfo.php" method="GET">

            <div class="form-group">
                <label for="summName" class="sr-only">Summoner Name</label>
                <input type="text" name="summName" class="form-control" placeholder="Summoner Name"
                       autofocus="autofocus" id="summName" required>
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

            <input type="submit" value="Search" class="btn btn-default"/>

        </form>
    </div>
    <div id="about">
        [This site] allows you to check whether or not you've unlocked your chest for all champions.
    </div>

</section>
<!--<div class="testing" style="position: fixed; bottom: 0;">-->
<footer style="position: absolute">
    <a href="testFiles/singleTest.php">Single test</a>
    <br>
    <a href="testFiles/functionTests.php">Function Tests</a>
</footer>
<!--</div>-->
</body>
</html>