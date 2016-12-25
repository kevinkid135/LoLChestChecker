<?php
// API Variables
include 'config.php'; // $API_KEY
$API_KEY = 'api_key=' . $API_KEY;
$API_URL = 'https://global.api.pvp.net';
$regionList = array('NA', 'BR', 'EUNE', 'EUW', 'JP', 'KR', 'LAN', 'LAS', 'OCE', 'RU', 'TR');

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
function useCURL($API_URL, $URL2) {
    $ch = curl_init(); // Initiates cURL
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Disable SSL verification
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // return response
    curl_setopt($ch, CURLOPT_URL, $API_URL . $URL2); // sets URL
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
    return array_values(json_decode($json, true));
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
    global $API_URL;
    $URL2 = '/api/lol/static-data/' . $region . '/v1.2/versions?' . $API_KEY;
    $result = useCURL($API_URL, $URL2);
    $result = json2arr($result);
    return $result[0];
}

/**
 * Returns the champion portrait link given region and champKey
 *
 * @param string $champKey champion Key
 * @param string $version current version
 *
 * @return string Champion portrait's link
 */
function getChampPortrait($champKey, $version) {
    return "http://ddragon.leagueoflegends.com/cdn/" . $version . "/img/champion/" . $champKey . ".png";
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
    global $API_URL;
    $URL2 = '/api/lol/static-data/' . $region . '/v1.2/champion?' . $API_KEY;
    $result = useCURL($API_URL, $URL2);
    $result = json2arr($result);
    $result = $result[2];
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
    global $API_URL;
    $URL2 = '/api/lol/static-data/' . $region . '/v1.2/champion?dataById=true&' . $API_KEY;
    $result = useCURL($API_URL, $URL2);
    $result = json2arr($result);
    $result = $result[2];
    return $result;
}

/**
 * Get champion name based on champion ID
 *
 * @param string $region
 * @param string $champID
 *
 * @return string The champion's name
 */
function getChampName($region, $champID) {
    global $API_KEY;
    global $API_URL;
    $URL2 = '/api/lol/static-data/' . $region . '/v1.2/champion/' . $champID . '?' . $API_KEY;
    $result = useCURL($API_URL, $URL2);
    $result = json2arr($result);

    return $result[2];
}

/**
 * Returns the champion ID given region and champion key.
 *
 * @param string $region
 * @param string $championKey First letter capital, not space
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
 * [id] int <br>
 * [name] string <br>
 * [key] string <br>
 * [title] string <br>
 * [image] imageDto <br>
 */
function getChampInfo_ARRAY($region, $champID) {
    global $API_KEY;
    global $API_URL;
    $URL2 = '/api/lol/static-data/' . $region . '/v1.2/champion/' . $champID . '?champData=image&' . $API_KEY;
    return json2arr(useCURL($API_URL, $URL2));
}

/******************
 * Riot API functions
 ******************/

/**
 * Mastery information on every champion obtained by summoner array of champions (use index) <br>
 *
 * @param string $region
 * @param string $summID
 *
 * @return array
 * An array of champions, specifically about champion mastery:<br>
 * [championID] int <br>
 * [championLevel] int <br>
 * [championPoints] int <br>
 * [championPointsSinceLastLevel] long <br>
 * [championPointsUntilNextLevel] long <br>
 * [chestGranted] boolean <br>
 * [lastPlayTime] long <br>
 * [playerId] long
 */
function getChampMasteryList_ARRAY($region, $summID) {
    global $API_KEY;
    global $API_URL;
    $URL2 = '/championmastery/location/' . $region . '1' . '/player/' . $summID . '/champions?' . $API_KEY;
    $result = useCURL($API_URL, $URL2);
    $result = json2arr($result);

    // error code obtained; try removing '1' from region.
    if (sizeof($result) < 2) {
        $URL2 = '/championmastery/location/' . $region . '/player/' . $summID . '/champions?' . $API_KEY;
        $result = useCURL($API_URL, $URL2);
        $result = json2arr($result);

        // summoner name not found in region
        if ($result[0]['status_code'] == 403) {
            echo "Summoner not found in region. Double spelling and region.";
            return NULL;
        }
    }
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
    global $API_URL;
    $URL2 = '/api/lol/' . $region . '/v1.4/summoner/by-name/' . $summName . '?' . $API_KEY;
    $result = useCURL($API_URL, $URL2);
    return json2arr($result)[0];
}

/**
 * Returns an array of the recent games the player has played.
 *
 * @param string $region
 * @param int $summID Summoner ID
 *
 * @return array list of recent matches
 */
function getRecentGames($region, $summID) {
    global $API_KEY;
    global $API_URL;
    $URL2 = '/api/lol/' . $region . '/v1.3/game/by-summoner/' . $summID . '/recent?' . $API_KEY;
    $result = useCURL($API_URL, $URL2);
    return json2arr($result)[1];
}

/**
 * Returns the time and date the user's first win of the day will be available
 *
 * @param string $region
 * @param string $summID summoner ID
 *
 * @return int time in seconds until first win of the day is available. <br>
 * 0 = available now <br>
 */
function fwotdTime($region, $summID) {
    $recentGames = getRecentGames($region, $summID);
    foreach ($recentGames as $game) {
        if ($game['gameType'] == 'MATCHED_GAME') {
            $currentTime = time();
            $gameTimeInSec = floor($game['createDate'] / 1000);
            if ($currentTime - $gameTimeInSec < 79200) {
                if ($game['ipEarned'] > 150) {
                    return $gameTimeInSec + 79200;
                } else {
                    break;
                }
            } else {
                return 0;
            }
        } else {
            break; // game does not count as FWOTD
        }
    }
    return 0;
}

