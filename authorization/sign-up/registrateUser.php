<?php
require_once '../../DBconnect.php';
require_once '../Authorization.php';

$dbConnect = new DBconnect();
$connection = $dbConnect::connectToDB();
$authorization = new Authorization($connection);

$name = filter_var(trim($_POST['name']));
$email = filter_var(trim($_POST['email']));
$password = filter_var(trim($_POST['password']));

$registrationResult = $authorization->registerUser($name, $email, $password);

if ($registrationResult === false) {
    print_r('Ошибка регистрации!');
} else {
    print_r('Регистрация прошла успешно!');
}