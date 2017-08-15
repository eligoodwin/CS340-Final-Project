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
$subtractionResult;
if(!$mysqli || $mysqli->connect_errno){
    echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>State Deletion Status Page</title>
</head>
<body>
<div>
    <h1>Status of state deletion:</h1>
    <?php
            if(!($statement = $mysqli->prepare("DELETE FROM states WHERE states.stateID = ?"))){
                echo "Prepare failed: "  . $statement->errno . " " . $statement->error;
            }

            if(!($statement->bind_param("i", $_POST['stateToDelete']))){
                echo "Bind failed: " . $statement->errno . " " . $statement->error;
            }
            //commit action
            $subtractionResult = $statement->execute();
            if(!$subtractionResult){
                echo "Hmm that was weird couldn't delete that state:(";
            }
            $statement->close();

            if($subtractionResult) {
                echo "<p>State has been deleted from the table. :) Here are the updated results</p>";
                echo "<table>\n";
                echo "<tr>\n<td>State</td>\n<td>Population</td>\n</tr>";
                if(!($statement2 = $mysqli->prepare("SELECT states.stateName, states.population FROM states"))){
                    echo "error some kind of other error occurred :/";
                }
                if(!$statement2->execute()) {
                    echo "Shit";
                }
                $statement2->bind_result($stateName, $statePopulation);

                while($statement2->fetch()){
                    echo "<tr>\n<td>" . $stateName . "</td>\n<td>" . $statePopulation . "</td>\n</tr>";
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