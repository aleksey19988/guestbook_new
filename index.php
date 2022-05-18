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
        <form action="#" method="POST" enctype="multipart/form-data" id="form" class="form-body">
            <div class="mb-3 form__item">
                <label for="inputUserName" class="form-label">User Name<span class="required-input-tag">*</span></label>
                <input type="text" class="form-input form-control _required" id="inputUserName" name="userName" >
            </div>
            <div class="mb-3 form__item">
                <label for="inputEmail" class="form-label">Email address<span class="required-input-tag">*</span></label>
                <input type="email" class="form-input form-control _required _email" id="inputEmail" name="email" aria-describedby="emailHelp" >
                <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
            </div>
            <div class="mb-3 form__item">
                <label for="inputHomepage" class="form-label">Homepage</label>
                <input type="url" placeholder="https://example.com" value="https://" class="form-input form-control _homepage" id="inputHomepage" name="homepage">
            </div>
            <div class="mb-3 form__item">
                <label for="inputText" class="form-label">Text<span class="required-input-tag">*</span></label>
                <input type="text" class="form-input form-control _required" id="inputText" name="text" >
            </div>
            <div class="mb-3 form__item file__item">
                <input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
                <input type="file" accept="image/jpeg, image/gif, image/png, text/plain" class="form-control-file" id="file-input" name="file-input">
                <button for="file-input" type="button" class="btn btn-primary file-input-btn">Выберите файл</button>
                <div id="file-preview" class="file-preview"></div>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
    <div class="container search-content">
        <h3>Search comments</h3>
        <form action="searchComments.php" class="search-form" method="get">
            <div class="form-group mb-3">
                <label for="inputState">Parameter</label>
                <select id="inputState" class="form-control" name="search-parameter">
                    <?php $content->showSearchParameters(); ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="search-value" class="form-label">Value<span class="required-input-tag">*</span></label>
                <input type="text" class="form-control" id="search-value" name="search-value" required>
            </div>
            <button class="btn btn-primary" type="submit">Search</button>
            <a href="./" class="reset-filter-link"><button class="btn btn-primary" type="button">Reset filter</button></a>
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
    <script src="sendForm.js"></script>
    </body>
</html>
