<?php
session_start();

include "../../DatabaseConnection.php";

$databaseConnection = new DatabaseConnection();
$databaseConnection->initiateConnection();
$connection = $databaseConnection->getConnection();

$profileId = $_SESSION['loggedUserId'];
$bestScore = $_POST['bestScore'];

$highScoreUpdateQuery = "UPDATE USERS SET HIGH_SCORE ='" . $bestScore . "'WHERE ID = '" . $profileId . "'";
$highScoreUpdateQueryResult = mysqli_query($connection, $highScoreUpdateQuery);

if (!$highScoreUpdateQueryResult) {
    throw new Exception("High score update query error");
}

mysqli_fetch_assoc($highScoreUpdateQueryResult);

$databaseConnection->killConnection();

?>