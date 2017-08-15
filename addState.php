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
<title>State Addition Status Page</title>
</head>
<body>
<h1>Status of state addition:</h1>
	<div>
		<?php

		if(!$mysqli || $mysqli->connect_errno){
		    echo "Connection Error" . $mysqli->connect_errno . " " . $mysqli->connect_error;
		}

		if(!($statement = $mysqli->prepare("INSERT INTO states (states.stateName, states.population) VALUES (?,?)"))){
		    echo "Prepare failed: "  . $statement->errno . " " . $statement->error;
		}

		if(!($statement->bind_param("si", $_POST['statename'], $_POST['population']))){
		    echo "Bind failed: " . $statement->errno . " " . $statement->error;
		}
        $additionResult = $statement->execute();
		if(!$additionResult){
		    echo "State already exists in the table :(";
		}
		$statement->close();
		if($additionResult){
		    echo "State has been added to table. :)";
		    //make a new table showing the results
            echo "<table>\n";
            echo "<tr>Updated State Data</tr>\n";
            echo "<tr>\n<td>State</td>\n<td>Population</td>\n</tr>";
            if(!($statement2 = $mysqli->prepare("SELECT states.stateName, states.population FROM states"))){
                echo "error some kind of other error occurred :/";
            }
            if(!$statement2->execute()){
                echo "Damnit";
            }
            $statement2->bind_result($stateName, $statePopulation);

            while($statement2->fetch()){
                echo "<tr>\n<td>" . $stateName . "</td><td>" . $statePopulation . "</td>\n</tr>";
            }
            $statement2->close();
		}
		?>
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