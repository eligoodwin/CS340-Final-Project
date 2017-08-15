<?php
/**
 * Created by PhpStorm.
 * User: eligoodwin
 * Date: 8/12/17
 * Time: 4:42 PM
 */
//database info
$mysqli = new mysqli("oniddb.cws.oregonstate.edu","goodwiel-db", "nBoPzqSHhgyr2Nei", "goodwiel-db" );
if($mysqli->connect_errno){
    echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>State Data</title>
</head>
<h1>State Data</h1>
<body>
<div>
    <fieldset>
        <table>
            <tr>
                <td>State Data</td>
            </tr>
            <tr>
                <td>State </td>
                <td>Population</td>
            </tr>
            <?php
            if(!($statement = $mysqli->prepare("SELECT states.stateName, states.population FROM states"))){
                echo "Prepare failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;
            }
            if(!$statement->execute()){
                echo "Damnit";
            }
            $statement->bind_result($stateName, $statePopulation);
            while($statement->fetch()){
                echo "<tr>\n<td>" . $stateName . "</td><td>" . $statePopulation . "</td>\n</tr>";
            }
            $statement->close();
            ?>
        </table>
    </fieldset>
</div>
<div>
    <p>If you want to add a state to the state database:</p>
    <fieldset>
        <form method="post" action="addState.php">
            <legend>State's Name: </legend>
            <input type="text" name="statename">
            <legend>State's Population: </legend>
            <input type="number" name="population">
            <p>
                <input type="submit" name="add" value="Add State"/>
        </form>
    </fieldset>
</div>
<div>
    <fieldset>
    <p>You can update a state here:</p>
        <form method="post" action="updateState.php">
            <legend>Filter by State:</legend>
                <select name="StateToUpdate">
                    <?php
                        //select state id and names
                    if(!($statement2 = $mysqli->prepare("SELECT states.stateID, states.stateName from states"))){
                        echo "massive failure";
                    }
                    if(!$statement2->execute()){
                        echo "Execution of selection failed.";
                    }
                    if(!$statement2->bind_result($stateId, $stateName)){
                        echo "bind failed";
                    }
                    while($statement2->fetch()){
                        echo '<option value=" '. $stateID . ' "> ' . $stateName . '</option>';
                    }
                    $statement2->close();
                    ?>
                </select>
                <p>State population: <input type="text" name="statePopulation"/></p>
            <input type="submit" name="add" value="Update State"/>
        </form>
    </fieldset>
</div>

<div>
    <fieldset>
        <p>You can delete a state below, just in case North Korea/Donald Trump kill us all </p>
        <form method="post" action="deleteState.php">
            <legend>Select the state you want to nuke.</legend>
                <select name="stateToDelete">
                    <?php
                        if(!($statement3 = $mysqli->prepare("SELECT states.stateID, states.stateName from states"))){
                            echo "massive failure";
                        }
                        if(!$statement3->execute()){
                            echo "Execution of selection failed.";
                        }
                        if(!$statement3->bind_result($id, $sname)){
                            echo "bind failed";
                        }
                        while($statement3->fetch()){
                            echo '<option value=" '. $id . ' "> ' . $sname . '</option>';
                        }
                        $statement3->close();
                        ?>
                    ?>
                </select>
            <input type="submit" value="Delete State"/>
        </form>
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