<?php

    include "../DatabaseConnection.php";

    $databaseConnection = new DatabaseConnection();
    $databaseConnection->initiateConnection();
    $connection = $databaseConnection->getConnection();

    $isPrivate = $_POST['isPrivate'];
    $course_id = $_POST['course_id']; // receiver_id if private..
    $sender_id = $_POST['sender_id'];
    $message = $_POST['message'];

    $sql_query = "INSERT INTO MESSAGES VALUES (0, '" . $course_id . "', '" . $sender_id . "', SYSDATE(), '" . $message . "')";

    if ($isPrivate)
        $sql_query = "UPDATE FRIENDSHIP SET MESSAGE = '" . $message . "' 
                      WHERE FIRST_USER_ID = '" . $sender_id . "' AND SECOND_USER_ID = '" . $course_id . "'";

    $sql_result = mysqli_query($connection, $sql_query);

    mysqli_fetch_assoc($sql_result);

    $databaseConnection->killConnection();

?>