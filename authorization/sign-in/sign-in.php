<?php
//require_once '../Authorization.php';
//require_once '../../DBconnect.php';
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="../authorization-style.css">
    <title>Registration</title>
</head>
<body>
<nav class="navbar navbar-expand-lg bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">Guestbook</a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
            </ul>
            <ul class="navbar-nav authorization-buttons">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/authorization/sign-in/sign-in.php">Войти</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/authorization/sign-up/sign-up.php">Зарегистрироваться</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div class="container">
    <h2 class="mt-5">Авторизация</h2>
    <form method="post" action="authorizeUser.php" class="sign-up-form mt-4">
        <div class="form-group">
            <label for="inputEmail">Email address<span class="required-input-tag">*</span></label>
            <input type="email" class="form-control" id="inputEmail" aria-describedby="emailHelp" placeholder="Enter email" name="email" required>
            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
        </div>
        <div class="form-group">
            <label for="inputPassword">Password<span class="required-input-tag">*</span></label>
            <input type="password" class="form-control" id="inputPassword" placeholder="Password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
</body>
</html>
