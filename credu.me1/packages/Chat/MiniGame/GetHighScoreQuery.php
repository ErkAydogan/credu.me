<?php
session_start();

include "../../DatabaseConnection.php";

$databaseConnection = new DatabaseConnection();
$databaseConnection->initiateConnection();
$connection = $databaseConnection->getConnection();

$profileId = $_SESSION['loggedUserId'];
$highScore;

$highScoreQuery = "SELECT HIGH_SCORE FROM USERS WHERE ID = '" . $profileId . "'";
$highScoreQueryResult = mysqli_query($connection, $highScoreQuery);

if (!$highScoreQueryResult) {
    throw new Exception("High score query error");
}

while ($row = mysqli_fetch_assoc($highScoreQueryResult)) {
    $highScore = $row["HIGH_SCORE"];
    echo json_encode($highScore);
}

$databaseConnection->killConnection();

?>