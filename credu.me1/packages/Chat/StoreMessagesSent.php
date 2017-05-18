<?php

    include "../DatabaseConnection.php";
    include "../User.php";
    include "ChatArea.php";

    $pathToLog = $_POST['pathToLog'];
    $chatRoomName = $_POST['chatRoomName'];

    $databaseConnection = new DatabaseConnection();
    $chatArea = new ChatArea($databaseConnection, $chatRoomName);

    $chatArea->fetchMessages();

    $fileStream = fopen($pathToLog, 'a');
    ftruncate($fileStream, 0);

    for($i = 0; $i < count($chatArea->getMessages()); $i++) {
        fwrite($fileStream, '<i>'  . $chatArea->getTimeDiff($chatArea->getDates()[$i])  . '</i>' .
                            '<h5>' . $chatArea->getSenders()[$i]->getFullName()         . '</h5>' .
                            '<p>'  . $chatArea->getMessages()[$i]                       . '</p><br>');
    }

    fclose($fileStream);

?>