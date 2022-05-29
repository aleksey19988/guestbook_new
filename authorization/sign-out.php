<?php

if (isset($_COOKIE['userName'])) {
    // Удаляем имя
    unset($_COOKIE['userName']);
    setcookie('userName', '', time() - 3600, '/');

    // Удаляем id пользователя
    unset($_COOKIE['userId']);
    setcookie('userId', '', time() - 3600, '/');

    // Переходим на главную
    header('Location: /');
}