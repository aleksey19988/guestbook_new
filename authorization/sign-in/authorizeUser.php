<?php
require_once '../../DBconnect.php';
require_once '../Authorization.php';

$dbConnect = new DBconnect();
$connection = $dbConnect::connectToDB();
$authorization = new Authorization($connection);

$email = filter_var(trim($_POST['email']));
$password = filter_var(trim($_POST['password']));

$result = $authorization->authorizeUser($email, $password);
if ($result === null) {
    print_r('Пользователь не найден!');
    header('Location ./sign-in.php');
} else {
    setcookie('userId', $result['id'], 0, '/');
    setcookie('userName', $result['name'], 0, '/');
    header('Location: /');
}