<!doctype html>

<html lang="en">
<head>
	<meta charset="utf-8">

	<title>Check Mastery Chest</title>
    <link rel="stylesheet" href="css/index.css">
</head>

<body>
<a href="testFiles/singleTest.php">Single test</a> <!-- for testing -->
<a href="testFiles/functionTests.php">Function Tests</a> <!-- for testing -->

<form action="php/chestInfo.php" method="GET">
        <input type="text" name="summName" placeholder="Summoner Name" autofocus="autofocus" required>
		<select name="region">
			<option value="NA">NA</option>
		<!-- Find out how to:
			Sort alphabetically, but will cache old selection
            -->
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
		<input type="submit" value="Search"/>
	</form>

</body>
</html>