# LoL-Mastery-Chest-Tracker
This application allows the user to search up a summoner name and see all chest availability for each champion. All data will be obtained from the riot API.

## Current Features
* Display a list of champions and display if the champion's chest has been unlocked yet.

## Planned Features
* Display champion portraits and graphically show that the chest if chest is unlocked or not
	* Needs to be blatenly clear at first glance if you do or do not have the chest unlocked.
* Sort by:
	* Highest mastery rank
	* Alphabetical
	* Champions with chests (then alphabetical)
	* Champions without chests (then alphabetical)
* Hide/show certain champions based on:
	* Chest availability
* Chest Obtained
* Champion Owned

## Unplanned features
These will be features that I've thought of, but have not figured out how to implement it yet

* First win of the day
	* Since the riot API doesn't give any information regarding if the FWOTD is up, I plan to calculate that on my own. A very simple case would be if no game has been won in the past 22 hours, it will be up.
	* If there has been a game won in the past 22 hours, I will need to check IP earned.
	
* Create an offline JSON file of static champion information.
	* This can be a script ran every time the version has changed since the last run.
	* The JSON file will 2 identical arrays for faster access:
		* champID => array(name, key, portraitURL)
		* champKey => array(name, ID, portraitURL)

### Personal Goals with this project:
* Create a usable and functional website
* Apply constant code refractoring to maintain clean and readbale code that is easily maintained in later stages
* Learn to work with an API (riot API)
* Have a high quality assurance
	* Avoid code smells
* Create test cases
* Learn to use GitHub
	* Creating a proper README
	* Comitting
	* Documenting changes
