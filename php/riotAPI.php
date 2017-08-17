<?php
// API Variables
include 'config.php'; // $API_KEY
$API_KEY = 'api_key=' . $API_KEY;
$regionList = array('na', 'br', 'eune', 'euw', 'jp', 'kr', 'lan', 'las', 'oce', 'ru', 'tr');
// due to legacy reasons, we have to convert the region string into an ID.
$regionIDArray = array('na' => 'na1', 'br' => 'br1', 'eune' => 'eun1', 'euw' => 'euw1', 'jp' => 'jp1', 'kr' => 'kr', 'lan' => 'la1', 'las' => 'la2', 'oce' => 'oce1', 'ru' => 'ru', 'tr' => 'tr1');

/****************
 * Helper Functions
 ****************/

/**
 * Helper function:<br>
 * Get JSON contents from Riot API.
 *
 * @param string $API_URL the first half of the URL, the part which is the same throughout all API requests
 * @param string $URL2 the second part, which changes depending on what information you want to get from the Riot API.
 *
 * @return string JSON results
 */
function useCURL($URL2) {
    $ch = curl_init(); // Initiates cURL
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Disable SSL verification
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // return response
    curl_setopt($ch, CURLOPT_URL, 'https://global.api.pvp.net' . $URL2); // sets URL
    $result = curl_exec($ch); // execute cURL
    curl_close($ch); // close cURL
    return $result;
}

function useCURL2($REGION, $URL2) {
    global $regionIDArray;
    $REGION = $regionIDArray[strtolower($REGION)];
    $ch = curl_init(); // Initiates cURL
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Disable SSL verification
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // return response
    curl_setopt($ch, CURLOPT_URL, 'https://' . $REGION . '.api.riotgames.com' . $URL2); // sets URL
    $result = curl_exec($ch); // execute cURL
    curl_close($ch); // close cURL
    return $result;
}

/**
 * Helper Function: <br>
 * Converts JSON string into an array, then into an array which can be accessed by index
 *
 * @param string $json
 *
 * @return array
 */
function json2arr($json) {
    //    return array_values(json_decode($json, true));
    return (json_decode($json, true));
}

/*****************************
 * Riot API functions (static)
 *****************************/

/**
 * Returns the current version of the game
 *
 * @param $region
 *
 * @return string Current version of the game
 */
function getCurrentVersion($region) {
    global $API_KEY;

    $URL2 = '/lol/static-data/v3/versions?' . $API_KEY;
    $result = useCURL2($region, $URL2);
    $result = json2arr($result);
    return $result[0];
}

/**
 * Returns the champion portrait link given region and champKey
 *
 * @param string $version current version
 * @param string $champKey champion Key
 *
 * @return string Champion portrait's link
 */
function getChampPortrait($version, $champKey) {
    return "http://ddragon.leagueoflegends.com/cdn/" . $version . "/img/champion/" . $champKey . ".png";
}

/**
 * Returns the summoner icon link given region and iconID
 *
 * @param string $version current version
 * @param string $iconID profile icon ID
 *
 * @return string profile icon id link
 */
function getSummonerIcon($version, $iconID) {
    return "http://ddragon.leagueoflegends.com/cdn/" . $version . "/img/profileicon/" . $iconID . ".png";
}

/**
 * Returns array of champions and simple information, where the key is the summoner key
 *
 * @param string $region
 *
 * @return array
 * Array of champions, with details:<br>
 * [0] id: int <br>
 * [1] key: string <br>
 * [2] name: string <br>
 * [3] title: string <br>
 */
function getChampListByKey($region) {
    global $API_KEY;

    $URL2 = '/lol/static-data/v3/champions?' . $API_KEY;
    $result = useCURL2($region, $URL2);
    $result = json2arr($result);
    $result = $result['data'];
    return $result;
}

/**
 * Returns array of champions and simple information, where the key is the summoner id
 *
 * @param string $region
 *
 * @return array
 * Array of champions, with details:<br>
 * [0] id: int <br>
 * [1] key: string <br>
 * [2] name: string <br>
 * [3] title: string <br>
 */
function getChampListById($region) {
    global $API_KEY;

    $URL2 = '/lol/static-data/v3/champions?dataById=true&' . $API_KEY;
    $result = useCURL2($region, $URL2);
    $result = json2arr($result);
    $result = $result['data'];
    return $result;
}

/**
 * Get champion name based on champion ID
 *
 * @param string $region
 * @param string $champID
 *
 * @return string The champion's name given its ID
 */
function getChampName($region, $champID) {
    global $API_KEY;

    $URL2 = '/lol/static-data/v3/champions/' . $champID . '?' . $API_KEY;
    $result = useCURL2($region, $URL2);
    $result = json2arr($result);

    return $result['name'];
}

/**
 * Returns the champion ID given region and champion key.
 *
 * @param string $region
 * @param string $championKey First letter capital, no space
 *
 * @return int The champion ID
 */
function getChampID($region, $championKey) {
    $champList = getChampListByKey($region);

    // finds champion id using champion key
    foreach ($champList as $key => $value) {
        if ($championKey == $key) {
            return $value['id'];
        }
    }

    return null; // champion not found
}

/**
 * Returns detailed information regarding a specific champion given champion ID
 *
 * @param string $region
 * @param string $champID
 *
 * @return array
 * Array of detailed information regarding a specific champion:<br>
 * [image] imageDto <br>
 * [title] string <br>
 * [name] string <br>
 * [key] string <br>
 * [id] int <br>
 */
function getChampInfo_ARRAY($region, $champID) {
    global $API_KEY;

    $URL2 = '/lol/static-data/v3/champions/' . $champID . '?champData=image&' . $API_KEY;
    return json2arr(useCURL2($region, $URL2));
}

/******************
 * Riot API functions
 ******************/

/**
 * Mastery information on every champion obtained by summoner array of champions (use index) <br>
 *
 * @param string $summID
 *
 * @return array
 * An array of champions, specifically about champion mastery:<br>
 * [playerId] int <br>
 * [championID] int <br>
 * [championLevel] int <br>
 * [championPoints] int <br>
 * [lastPlayTime] float <br>
 * [championPointsSinceLastLevel] int <br>
 * [championPointsUntilNextLevel] int <br>
 * [chestGranted] boolean <br>
 * [tokensEarned] int <br>
 */
function getChampMasteryList_ARRAY($region, $summID) {
    global $API_KEY;
    $region = strtolower($region);
    $URL2 = '/lol/champion-mastery/v3/champion-masteries/by-summoner/' . $summID . '?' . $API_KEY;
    $result = useCURL2($region, $URL2);
    $result = json2arr($result);
    return $result;
}

/**
 * Returns summoner information
 *
 * @param string $region
 * @param string $summName
 *
 * @return array
 * Array of information regarding a particular summoner:<br>
 * [id] long <br>
 * [name] string <br>
 * [profileIconId] int <br>
 * [revisionDate] long <br>
 * [summonerLevel] long <br>
 */
function getSumm_ARRAY($region, $summName) {
    $summName = preg_replace('/\s+/', '', $summName); // remove spaces from name
    global $API_KEY;

    $URL2 = '/lol/summoner/v3/summoners/by-name/' . $summName . '?' . $API_KEY;
    $result = useCURL2($region, $URL2);
    return json2arr($result);
}

/**
 * Returns the account ID
 *
 * @param $region
 * @param $summName
 * @return int
 */
function getAccId($region, $summName) {
    return getSumm_ARRAY($region, $summName)['accountId'];
}

/**
 * Returns an array of the recent games the player has played.
 *
 * @param string $region
 * @param int $summID Summoner ID
 *
 * @return array list of recent matches
 */
function getRecentGames($region, $accID) {
    global $API_KEY;

    $URL2 = '/lol/match/v3/matchlists/by-account/' . $accID . '/recent?' . $API_KEY;
    $result = useCURL2($region, $URL2);
    return json2arr($result)['matches'];
}

/**
 * Given the matchID, get the array regarding the match. <br>
 * Function is used to calculate first win of the day
 *
 * @param $region
 * @param $matchID
 * @param $accID
 * @return array JSON data regarding the match
 */
function getMatch($region, $matchID, $accID) {
    global $API_KEY;
    $URL2 = '/lol/match/v3/matches/' . $matchID . '?forAccountId=' . $accID . '&' . $API_KEY;
    $result = useCURL2($region, $URL2);
    return $result;
}

/**
 * Returns the time and date the user's first win of the day will be available
 *
 * @param string $region
 * @param string $summID summoner ID
 *
 * @return int time in seconds until first win of the day is available. <br>
 * 0 = available now <br>
 * -1 = no game found which would indicate that haven't played in a while, and it should be up
 */
function fwotdTime($region, $accID) {
    $gameEndTime = -1;
    $recentGames = getRecentGames($region, $accID);
    // loop through each game, and find if it's a win or not
    foreach ($recentGames as $game) {
        // grab the matchId
        $matchId = $game['gameId'];
        // use matchID to locate game (in array form)
        $matchArr = json2arr(getMatch($region, $matchId, $accID));
        // go inside "participantIdentities" and find out which one contains a length of 2
        // grab the participant index of that
        $participantId = -1;

        foreach ($matchArr['participantIdentities'] as $participant) {
            if (count($participant) == 2 && $participant['player']['accountId'] == $accID) {
                $participantId = $participant['participantId'];
                break;
            }
        }

        // assert that we've found the participant
        if ($participantId == -1) {
            return -1;
        }
        // go inside "participants", and use participantID to get teamID
        $teamId = -1;
        foreach ($matchArr['participants'] as $participant) {
            if ($participant['participantId'] == $participantId) {
                $teamId = $participant['teamId'];
            }
        }

        // assert that we've found the team
        if ($teamId == -1) {
            return -1;
        }

        // use teamID and go into "teams"
        // check if they won
        foreach ($matchArr['teams'] as $team) {
            if ($team['teamId'] == $teamId) {
                if ($team['win'] != "Win") {
                    // tie/lost
                } else {
                    // they won
                    // game start time
                    $gameStartTime = $matchArr['gameCreation'];
                    // duration
                    $gameDuration = $matchArr['gameDuration'];

                    $gameEndTime = $gameStartTime + $gameDuration;
                    break;
                }
            }
        }

        if ($gameEndTime != -1) {
            break;
        }

    }
    return $gameEndTime; // TODO IP earned has been depricated. Find how to calculate with other data
}

