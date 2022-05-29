<?php
require_once 'DBconnect.php';

$name = trim(htmlspecialchars($_POST['name']));
$email = trim(htmlspecialchars($_POST['email']));
$homepage = trim(htmlspecialchars(($_POST['homepage'])));
$text = trim(htmlspecialchars(($_POST['text'])));
$id = $_POST['id'];

$connection = DBconnect::connectToDB();

$result = $connection->query("UPDATE comments SET name = '$name', email = '$email', homepage = '$homepage', text = '$text' WHERE id = '$id'");

if ($result == false) {
    print_r('Ошибка!');
} else {
    header('Location: /');
}