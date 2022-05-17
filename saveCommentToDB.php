<?php
require_once 'Comment.php';

if (isset($_POST['userName'])
    && isset($_POST['email'])
    && isset($_POST['text'])
) {
    $userName = htmlspecialchars($_POST['userName']);
    $email = htmlspecialchars($_POST['email']);
    $text = htmlspecialchars($_POST['text']);
    $homePage = htmlspecialchars($_POST['homepage']) ?: '';
    $ipAddress = $_SERVER['REMOTE_ADDR'];
    $browser = $_SERVER['HTTP_USER_AGENT'];
    $dateTime = new DateTime('now');
    $dateAdded = $dateTime->format('Y-m-d');

    $comment = new Comment($userName, $email, $homePage, $text, $ipAddress, $browser, $dateAdded);

    $result = $comment->saveCommentToDB();
    var_dump($result);
    if (!$result) {
        //TODO Добавить отображение ошибки если данные не записались в БД. Сейчас не работает alert() из-за редиректа
        header('Location: ./404/404.html');
    } else {
        header('Location: ./success.html');
    }
} else {
    print_r('Заполнены не все обязательные поля');
}