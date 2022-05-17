<?php
include_once 'Content.php';

$content = new Content();
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Guestbook</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
        <link rel="stylesheet" href="style/style.css">
    </head>
    <body>
    <nav class="navbar navbar-expand-lg bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="./">Guestbook</a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                </ul>
                <ul class="navbar-nav authorization-buttons">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Sign In</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Sign Up</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container form-content">
        <h3>Input form</h3>
        <form action="saveCommentToDB.php" method="POST">
            <div class="mb-3">
                <label for="inputUserName" class="form-label">User Name<span class="required-input-tag">*</span></label>
                <input type="text" class="form-control" id="inputUserName" name="userName" required>
            </div>
            <div class="mb-3">
                <label for="inputEmail" class="form-label">Email address<span class="required-input-tag">*</span></label>
                <input type="email" class="form-control" id="inputEmail" name="email" aria-describedby="emailHelp" required>
                <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
            </div>
            <div class="mb-3">
                <label for="inputHomepage" class="form-label">Homepage</label>
                <input type="url" placeholder="https://example.com" pattern="https://.*" class="form-control" id="inputHomepage" name="homepage">
            </div>
            <div class="mb-3">
                <label for="inputText" class="form-label">Text<span class="required-input-tag">*</span></label>
                <input type="text" class="form-control" id="inputText" name="text" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
    <div class="container search-content">
        <h3>Search comments</h3>
        <form action="searchComments.php" class="search-form" method="get">
            <div class="form-group mb-3">
                <label for="inputState">Parameter</label>
                <select id="inputState" class="form-control">
                    <?php $content->showSearchParameters(); ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="search-value" class="form-label">Value<span class="required-input-tag">*</span></label>
                <input type="text" class="form-control" id="search-value" name="search-value" required>
            </div>
            <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="button">Search</button>
            </div>
        </form>
    </div>
    <div class="container table-content">

        <table class="table table-hover">
            <?php $content->showComments(); ?>
        </table>
    </div>
    <div class="container page-list" align="center">
        <?php $content->showPagesLinks($content->getPagesCount()); ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    </body>
</html>
