<?php

class Login {
    /** @var DatabaseConnection */
    private $databaseConnection = null;
    /** @var null */
    private $loggedUserId = null;
    private $latestError = null;

    public function __construct($databaseConnection) {
        $this->databaseConnection = $databaseConnection;
    }

    public function login($email, $password) {
        $this->databaseConnection->initiateConnection();
        $connection = $this->databaseConnection->getConnection();

        $email = $this->getProtectedInput($email);
        $password = $this->getProtectedInput($password);

        $sql_query   = "SELECT * FROM USERS WHERE EMAIL = '" . $email . "'";
        $sql_result  = mysqli_query($connection, $sql_query);
        $num_of_rows = mysqli_num_rows($sql_result);

        $this->checkLogin($email, $password, $num_of_rows, $sql_result);
        $this->databaseConnection->killConnection();
    }

    /** ================ Protection against SQL injection ================ */
    private function getProtectedInput($input, $formUse = true) {
        $input = preg_replace("/(from|select|insert|delete|where|drop table|show tables|,|'|#|\*|--|\\\\)/i", "", $input);
        $input = trim($input);
        $input = strip_tags($input);

        if (!$formUse || !get_magic_quotes_gpc())
            $input = addslashes($input);

        return $input;
    }

    private function checkLogin($email, $password, $num_of_rows, $sql_result) {
        if (!$email || !$password) {
            $this->latestError = "Email or password cannot be empty..";
        } else {
            if ($num_of_rows) {
                $row = mysqli_fetch_assoc($sql_result);

                if (!strcmp($password, $row["PASSWORD"])) {
                    $this->processLogin($row);
                } else {
                    $this->latestError = "Password that you typed is wrong..";
                }
            } else {
                $this->latestError = "Email that you typed is wrong..";
            }
        }
    }

    private function processLogin($row) {
        $this->loggedUserId = $row['ID'];
    }

    public function getLoggedUserId() {
        return $this->loggedUserId;
    }

    public function getLatestError() {
        return $this->latestError;
    }
}