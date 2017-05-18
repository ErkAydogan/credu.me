<?php

const MAX_AMOUNT_OF_MESSAGES = 100; // Maximum amount of messages to be displayed

class ChatArea {
    /** @var DatabaseConnection */
    private $databaseConnection = null;
    /** @var null */
    private $course_id = null;
    private $registeredUsers = null;
    private $senders = null;
    private $dates = null;
    private $messages = null;

    public function __construct($databaseConnection, $course_id) {
        $this->databaseConnection = $databaseConnection;
        $this->course_id = $course_id;

        $this->fetchRegisteredUsers();
    }

    private function fetchRegisteredUsers() {
        $this->registeredUsers = array();

        $this->databaseConnection->initiateConnection();
        $connection = $this->databaseConnection->getConnection();

        $sql_query = "SELECT USERS.ID FROM COURSESTAKEN JOIN USERS 
                                      ON COURSESTAKEN.USER_ID = USERS.ID WHERE COURSE_ID = '" . $this->course_id . "'";
        $sql_result = mysqli_query($connection, $sql_query);

        while ($row = mysqli_fetch_assoc($sql_result))
            $this->registeredUsers[] = new User($this->databaseConnection, $row['ID']);

        $this->databaseConnection->killConnection();
    }

    public function fetchMessages() {
        $this->clearArrays();

        $this->databaseConnection->initiateConnection();
        $connection = $this->databaseConnection->getConnection();

        $sql_query = "SELECT * FROM MESSAGES WHERE COURSE_ID = '" . $this->course_id . "'
                      ORDER BY ID DESC LIMIT " . MAX_AMOUNT_OF_MESSAGES;
        $sql_result = mysqli_query($connection, $sql_query);

        while ($row = mysqli_fetch_assoc($sql_result)) {
            $this->senders[] = new User($this->databaseConnection, $row['SENDER_ID']);
            $this->dates[] = $row['DATE'];
            $this->messages[] = $row['MESSAGE'];
        }

        $this->databaseConnection->killConnection();
    }

    private function clearArrays() {
        $this->senders = array();
        $this->dates = array();
        $this->messages = array();
    }

    public function getTimeDiff($date) {
        $messageTime = strtotime($date);
        $currentTime = strtotime(date('Y-m-d H:i:s'));

        $timeDiffInSeconds = $currentTime - $messageTime;
        $timeDiffInMinutes = $timeDiffInSeconds / 60;
        $timeDiffInHours = $timeDiffInMinutes / 60;
        $timeDiffInDays = $timeDiffInHours / 24;

        return $this->getTimeDiffWithMessage($timeDiffInMinutes, $timeDiffInHours, $timeDiffInDays);
    }

    private function getTimeDiffWithMessage($timeDiffInMinutes, $timeDiffInHours, $timeDiffInDays) {
        if (floor($timeDiffInMinutes) < 1)
            return 'less than a minute ago..';
        else if (floor($timeDiffInMinutes) == 1)
            return 'a minute ago..';
        else if (floor($timeDiffInMinutes) < 60)
            return floor($timeDiffInMinutes) . ' minutes ago..';
        else if (floor($timeDiffInHours) < 2)
            return 'an hour ago..';
        else if (floor($timeDiffInHours) < 48)
            return floor($timeDiffInHours) . ' hours ago..';
        else if (floor($timeDiffInDays) <= 7)
            return floor($timeDiffInDays) . ' days ago..';
        else
            return 'more than a week ago..';
    }

    public function isCourseTakenBy($userId) {
        for ($i = 0; $i < count($this->getRegisteredUsers()); $i++)
            if ($this->getRegisteredUsers()[$i]->getUserId() == $userId)
                return true;

        return false;
    }

    public function getRegisteredUsers() {
        return $this->registeredUsers;
    }

    public function getSenders() {
        return $this->senders;
    }

    public function getDates() {
        return $this->dates;
    }

    public function getMessages() {
        return $this->messages;
    }
}

?>