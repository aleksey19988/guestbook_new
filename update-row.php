<?php
require_once 'Content.php';
$content = new Content();

$result = $content->getCommentById($_GET['id']);
?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="style/style.css">
    <title>Редактирование комментария</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="./">Guestbook</a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                </ul>
                <?php if (count($_COOKIE) === 0): ?>
                    <ul class="navbar-nav authorization-buttons">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="/authorization/sign-in/sign-in.php">Войти</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="/authorization/sign-up/sign-up.php">Зарегистрироваться</a>
                        </li>
                    </ul>
                <?php else: ?>
                    <ul class="navbar-nav authorization-buttons authorized-user-list">
                        <li class="user-greeting-item-list">
                            <p class="user-greeting">Привет, <?php echo $_COOKIE["userName"] ?>!</p>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="./authorization/sign-out.php">Выйти</a>
                        </li>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2>Редактирование комментария</h2>
        <form action="edit-message.php" class="edit-form form-body" method="post">
            <?php foreach ($result as $key => $value): ?>
            <div class="form-group">
                <?php if ($key === 'id'): ?>
                    <label for="<?= $key ?>" class="mt-3"><?= $key ?></label>
                    <input type="text" value="<?= $value ?>" id="<?= $key ?>" class="form-control" name="<?=$key?>" readonly>
                <?php else: ?>
                    <label for="<?= $key ?>" class="mt-3"><?= $key ?></label>
                    <input type="text" value="<?= $value ?>" id="<?= $key ?>" class="form-control" name="<?=$key?>">
                <?php endif;?>
            </div>
            <?php endforeach; ?>
            <button type="submit" class="btn btn-primary mt-3">Submit</button>
        </form>
    </div>
</body>
</html>
