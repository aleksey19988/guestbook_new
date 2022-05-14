<?php

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
                <a class="navbar-brand" href="#">Guestbook</a>
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
        <div class="container">
            <form>
                <div class="mb-3">
                    <label for="inputUserName" class="form-label">User Name<span class="required-input-tag">*</span></label>
                    <input type="text" class="form-control" id="inputUserName" required>
                </div>
                <div class="mb-3">
                    <label for="inputEmail" class="form-label">Email address<span class="required-input-tag">*</span></label>
                    <input type="email" class="form-control" id="inputEmail" aria-describedby="emailHelp" required>
                    <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                </div>
                <div class="mb-3">
                    <label for="inputHomepage" class="form-label">Homepage</label>
                    <input type="url" placeholder="https://example.com" pattern="https://.*" class="form-control" id="inputHomepage">
                </div>
                <div class="mb-3">
                    <label for="inputText" class="form-label">Text<span class="required-input-tag">*</span></label>
                    <input type="text" class="form-control" id="inputText" required>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    </body>
</html>