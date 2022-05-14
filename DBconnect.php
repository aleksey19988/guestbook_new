<?php
require_once 'pdoconfig.php';

class DBconnect {
    public static function connectToDB() {
        try {
            $conn = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, USERNAME, PASSWORD);
            echo "Connected to $dbname at $host successfully.";
        } catch (PDOException $pe) {
            die("Could not connect to the database $dbname :" . $pe->getMessage());
        }

        return $conn;
    }
}