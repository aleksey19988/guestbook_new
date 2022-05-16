<?php
require_once 'Comment.php';

if (isset($_POST['userName'])
    && isset($_POST['email'])
    && isset($_POST['text'])
    ) {
    $userName = $_POST['userName'];
    $email = $_POST['email'];
    $text = $_POST['text'];
    $homePage = $_POST['homepage'] ? $_POST['homepage'] : '';
    $ipAddress = $_SERVER['REMOTE_ADDR'];
    $browser = get_browser($_SERVER['HTTP_USER_AGENT'], true) ? get_browser($_SERVER['HTTP_USER_AGENT'], true)['browser'] : $_SERVER['HTTP_USER_AGENT'];
    $dateTime = new DateTime('now');
    $dateAdded = $dateTime->format('Y-m-d');

    $comment = new Comment($userName, $email, $homePage, $text, $ipAddress, $browser, $dateAdded);

    $result = $comment->saveCommentToDB();

    if ($result) {
        header('./');
    } else {
        print_r('Ошибка при сохранении данных в БД');
        sleep(5);
        header('Location: ./');
    }
} else {
    print_r('Заполнены не все обязательные поля');
}