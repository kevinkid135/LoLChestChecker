<?php
// API Variables
include 'config.php'; // $API_KEY
$API_URL = 'https://na.api.pvp.net';

/* Helper function: converts jason strong into array, then into array which can be accessed by index */
function json2arr($j){
	return array_values(json_decode($j, true));
}

/* Returns summoner ID given summoner name and region */
function getSummID($region, $summName){
	global $API_KEY;
	global $API_URL;
	$URL2 = '/api/lol/' . $region . '/v1.4/summoner/by-name/' . $summName . '?api_key=' . $API_KEY;

	// cURL
	$ch = curl_init(); // Initiates cURL
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Disable SSL verification
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // return response
	curl_setopt($ch, CURLOPT_URL, $API_URL . $URL2); // sets URL
	$result=curl_exec($ch); // execute cURL
	curl_close($ch); // close cURL

	// $jsonDecoded = json_decode($result, true); // decode json string into array
	// $arr = array_values($jsonDecoded); // allows access of array by index
	// return $arr[0]['id'];

	// get id
	$id = json2arr($result);
	return $id[0]['id'];
}

/* Returns the list of champions sorted in alphabetical order */
function getChampionList($region){
	global $API_KEY;
	global $API_URL;
	$URL2 = '/api/lol/static-data/'. $region .'/v1.2/champion' . '?api_key=' . $API_KEY;

	// cURL
	$ch = curl_init(); // Initiates cURL
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Disable SSL verification
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // return response
	curl_setopt($ch, CURLOPT_URL, $API_URL . $URL2); // sets URL
	$result=curl_exec($ch); // execute cURL
	curl_close($ch); // close cURL

	// fill champList with champion names
	foreach(json2arr($result)[2] as $key => $value){
		$champList[] = $key;
	}

	sort($champList);

	return $champList;
}

?>