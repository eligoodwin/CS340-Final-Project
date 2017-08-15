<?php
/**
 * Created by PhpStorm.
 * User: eligoodwin
 * Date: 8/14/17
 * Time: 8:36 PM
 */
$mysqli = new mysqli("oniddb.cws.oregonstate.edu","goodwiel-db", "nBoPzqSHhgyr2Nei", "goodwiel-db" );
if($mysqli->connect_errno){
    echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Committee Data</title>
</head>
<h1>Committee Data</h1>
<body>
<div>
    <fieldset>
        <p>This table shows all the committees that senators in this database are members of.</p>
        <table>
            <tr>
                <td>Committees:</td>
            </tr>
            <tr>
                <td>Committee Name</td>
                <td>Committee Purpose</td>
            </tr>
            <?php
                if(!($statement =$mysqli->prepare("SELECT committee.committeeName, committee.committeePurpose FROM committee"))){
                    echo "Prepare failed";
                }
                if($statement->execute()){
                    echo "execute failed";
                }
                $statement->bind_result($name, $purpose);
                while($statement->fetch()){
                    echo "<tr>\n<td>" . $name . "</td><td>" . $purpose . "</td>\n</tr>";
                }
                $statement->close();
            ?>
        </table>
    </fieldset>
</div>
<div>
    <p>You can add a new committee: </p>
    <fieldset>
        <form method="post" action="addCommittee.php">
            <legend>Committee Name: </legend>
            <input type="text" name="committeeName">
            <legend>Committee Purpose: </legend>
            <input type="text" name="committeePurpose">
            <p>
                <input type="submit" name="add" value="Add Committee"/>
            </p>
        </form>
    </fieldset>
</div>

<div>
    <fieldset>
        <p>You can delete a committee: </p>
    </fieldset>
</div>

<div>
    <fieldset>
        <p>You can filter committee membership by senator:</p>
    </fieldset>
</div>
    <fieldset>
        <P>You can add a senator to a committee: </P>
    </fieldset>
<div>

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
