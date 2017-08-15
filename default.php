<?php
	/**
	 * Created by PhpStorm.
	 * User: eligoodwin
	 * Date: 8/12/17
	 * Time: 4:42 PM
	 */
	//database info

	ini_set('display_errors', 'On');
	$mysqli = new mysqli("oniddb.cws.oregonstate.edu","goodwiel-db", "nBoPzqSHhgyr2Nei", "goodwiel-db" );
	$additionResult;
	if(!$mysqli || $mysqli->connect_errno){
	    echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}
?>
<!DOCTYPE html>
<html>
<head>
<title>Basic Senate Database</title>
</head>
<body>
	<div>
		<fieldset>
			<h1>Introduction: </h1>
			<p>This is a simple database containing data for senators representing the 5 most western continental US states—WA, OR, CA ID, UT, NV, and AZ. You will be able to view data regarding: party membership, state, recent senator voting history, and senator committee membership.</p> 
			<p>This site will also allow you to add or delete bills, committees, political parties, senators, states, and filter voting history by political party. 
			Below basic senate info will be displayed.
			</p>
		</fieldset>
	</div>
	<div>
		<fieldset>
		<h2>Senate Data: </h2>
		<table>
		<tr>
			<td>Senator Name</td>
			<td>Senator Party</td>
			<td>Senator's State</td>	
		</tr>
		<?php
			//get statement 
			if(!($statement = $mysqli->prepare("SELECT senators.firstName, senators.lastName, party.partyName, states.stateName FROM senators JOIN states ON states.stateId = senators.stateID JOIN party ON party.partyID = senators.partyID"))){
				echo "Error with database record reterivial....";
				}
			if(!$statement->execute()){
				echo "Something went wrong wtih the database query....";
			}
			//format it
			$statement->bind_result($firstName, $lastName, $partyName, $stateName);
			while($statement->fetch()){
				echo "<tr>\n<td>" . $firstName . " " . $lastName . "</td><td>" . $partyName . "</td><td>". $stateName .  "</td>\n</tr>";
			}
			$statement->close();
		?>
		</table>
		</fieldset>
	</div>
    <div>
        <p>From below, you can navigate to the following: </p>
        <ul>
            <li><a href="displayStates.php">View state and modify state data</a></li>
            <li><a href="displaySenators.php">View senator and modify senator data</a></li>
            <li><a href="displayBill.php">View bill and modify senate bills</a></li>
            <li><a href="displayParty.php">View party and modfiy party data</a></li>
        </ul>
    </div>
</body>
</html>