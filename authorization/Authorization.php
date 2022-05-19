<?php
require_once '../../DBconnect.php';

class Authorization
{
    private $dbConnect;

    public function __construct($dbConnect)
    {
        $this->dbConnect = $dbConnect;
    }

    public function registerUser($name, $login, $password)
    {
        $password = md5($password);
        $query = "INSERT INTO users (name, email, password) VALUES ('$name', '$login', '$password')";

        return $this->dbConnect->query($query);
    }

    public function authorizeUser($email, $password)
    {
        $password = md5($password);
        $query = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";

        return $this->dbConnect->query($query)->fetchAll()[0];
    }

    public function signOut()
    {

    }
}