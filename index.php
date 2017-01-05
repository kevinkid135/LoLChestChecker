<!doctype html>

<html lang="en">
<head>
    <title>LoL Chest Checker</title>

    <meta charset="utf-8">
    <meta name="description"
          content="League of Legends mastery chest checker. Check which champions you've unlocked a chest for, and also know when your first win of the day is up.">
    <meta name="keywords" content="lol, League of Legends, chest, mastery, first win of the day, fwotd, lolcc">
    <meta name="author" content="kevinkid135">

    <!-- CSS Files-->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/index.css">
</head>

<body>

<header>
    <h1>LoLcc - League of Legends Chest Checker</h1>
</header>

<section>
    <div id="header">
        <img src="img/Hextech_Crafting.jpg" id="chest-img">
    </div>
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
        LoLcc allows you to check whether or not you've unlocked your chest for all champions. We also provide you with
        the ability to calculate when your first win of the day is up, accurate as long as no IP boosters are used.
    </div>

</section>
<footer>
    <p>LoLcc isn't endorsed by Riot Games and doesn't reflect the views or opinions of Riot
        Games or anyone officially involved in producing or managing League of Legends. League of Legends and Riot Games
        are trademarks or registered trademarks of Riot Games, Inc. League of Legends © Riot Games, Inc.</p>
</footer>
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