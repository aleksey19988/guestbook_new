<?php
require_once 'pdoconfig.php';

class DBconnect {
    public function connectToDB() {
        try {
            $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            echo "Connected to $dbname at $host successfully.";
        } catch (PDOException $pe) {
            die("Could not connect to the database $dbname :" . $pe->getMessage());
        }

        return $conn;
    }
}