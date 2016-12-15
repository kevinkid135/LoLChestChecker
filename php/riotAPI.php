<?php
// API Variables
include 'config.php'; // $API_KEY
$API_KEY = '?api_key=' . $API_KEY;
$API_URL = 'https://global.api.pvp.net';

/****************
 * Helper Functions
 ****************/

/**
 * Helper function: Get JSON contents from Riot API.
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
 * Returns array of champions and simple information
 *
 * @param string $region
 *
 * @return array
 * Array of champions, with details:<br>
 * [0] id: int <br>
 * [1] key: string <br>
 * [2] name: string <br>
 * [3] title: string <br>
 * [4] array: image filenames
 */
function getChampList_ARRAY($region) {
    global $API_KEY;
    global $API_URL;
    $URL2 = '/api/lol/static-data/' . $region . '/v1.2/champion' . $API_KEY;
    $result = useCURL($API_URL, $URL2);
    $result = json2arr($result);
    $result = $result[2];
    return $result;
}

/**
 * Static Elements:<br>
 * Returns an array of champion keys
 *
 * @param string $region
 *
 * @return array Array of champions keys
 */
function getChampList_KEY($region) {
    $result = getChampList_ARRAY($region);
    // fill champList with champion keys
    foreach ($result as $key => $value) {
        $champList[] = $key;
    }
    // sort($champList);
    return $champList;
}

/**
 * Returns an array of champion names sorted in alphabetical order
 *
 * @param string $region
 *
 * @return array Array of champions names
 */
function getChampList_NAME($region) {
    $result = getChampList_ARRAY($region);
    // fill champList with champion names
    foreach ($result as $key => $value) {
        $champList[] = $value['name'];
    }
    sort($champList);
    return $champList;
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
    $URL2 = '/api/lol/static-data/' . $region . '/v1.2/champion/' . $champID . $API_KEY;
    $result = useCURL($API_URL, $URL2);
    $result = json2arr($result);

    return $result[2];
}

/******************
 * Riot API functions
 ******************/


/**
 * Returns the champion ID given region and champion key.
 *
 * @param string $region
 * @param string $championKey First letter capital, not space
 *
 * @return int The champion ID
 */
function getChampID($region, $championKey) {
    $champList = getChampList_ARRAY($region);

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
    $newAPIKEY = substr($API_KEY, 1); // remove the '?' at the beginning of the string to append otions
    $URL2 = '/api/lol/static-data/' . $region . '/v1.2/champion/' . $champID . '?champData=image&' . $newAPIKEY;
    return json2arr(useCURL($API_URL, $URL2));
}

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
    $URL2 = '/championmastery/location/' . $region . '1' . '/player/' . $summID . '/champions' . $API_KEY;
    $result = useCURL($API_URL, $URL2);
    $result = json2arr($result);

    // error code obtained; try removing '1' from region.
    if (sizeof($result) < 2) {
        $URL2 = '/championmastery/location/' . $region . '/player/' . $summID . '/champions' . $API_KEY;
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
    $URL2 = '/api/lol/' . $region . '/v1.4/summoner/by-name/' . $summName . $API_KEY;
    $result = useCURL($API_URL, $URL2);
    return json2arr($result)[0];
}


