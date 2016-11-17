<?php
// API Variables
include 'config.php'; // $API_KEY
$API_URL = 'https://na.api.pvp.net';

/*  Helper function: Get josn contents from Riot API.
	$API_URL is the first half of the URL, the part which is the same throughout all API requests
	$URL2 is the second part, which changes depending on what information you want to get from the Riot API.
 */
	function useCURL($API_URL, $URL2){
	$ch = curl_init(); // Initiates cURL
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Disable SSL verification
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // return response
	curl_setopt($ch, CURLOPT_URL, $API_URL . $URL2); // sets URL
	$result=curl_exec($ch); // execute cURL
	curl_close($ch); // close cURL
	return $result;
}

/*  Helper function: converts jason string into an array,
then into array which can be accessed by index */
function json2arr($j){
	return array_values(json_decode($j, true));
}

/* Helper Function: Returns an array of champion keys*/
function getChampList_KEY($region){
	$result = getChampList_JSON($region);
	// fill champList with champion keys
	foreach(json2arr($result)[2] as $key => $value){
		$champList[] = $key;
	}
	// sort($champList);
	return $champList;
}

/* Returns the champion list in JSON format */
function getChampList_JSON($region){
	global $API_KEY;
	global $API_URL;
	$URL2 = '/api/lol/static-data/'. $region .'/v1.2/champion' . '?api_key=' . $API_KEY;
	return useCURL($API_URL, $URL2);
}

/*  Returns summoner ID,
given summoner name and region */
function getSummID($region, $summName){
	global $API_KEY;
	global $API_URL;
	$URL2 = '/api/lol/' . $region . '/v1.4/summoner/by-name/' . $summName . '?api_key=' . $API_KEY;
	$result = useCURL($API_URL, $URL2);
	return json2arr($result)[0]['id']; // get only the ID
}

/* Returns an array of champion names sorted in alphabetical order */
function getChampList_NAME($region){
	$result = getChampList_JSON($region);
	// fill champList with champion names
	foreach(json2arr($result)[2] as $key => $value){
		$champList[] = $value['name'];
	}
	sort($champList);
	return $champList;
}

/*  Returns the champion ID
	given region and champion key*/
function getChampID($region, $championKey){
	$result = getChampList_JSON($region);
	$champList = json2arr($result);

	// finds champion id using champion key
	foreach ($champList[2] as $key => $value) {
		if ($championKey == $key){
			return $value['id'];
		}
	}
	return NULL; // champion not found
}

//TODO check if chest is already unlocked for champion
function chestGranted($region, $champID){
	
}

?>