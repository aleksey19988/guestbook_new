<!DOCTYPE html>
<html>
	<head>
		<title>404 – страница не найдена</title>
		<meta charset="utf-8">
		<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,700&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" href="./404-style.css">
	</head>
	<body>
	<div class="container">
        <div class="content">
            <h2>Ошибка при сохранении данных:</h2>
            <ul>
                <?php
                foreach ($_GET as $key => $value) {
                    $value = urldecode($value);
                    print_r("<li>$value</li>");
                }
                ?>
            </ul>
            <a href="/">Перейти к главной странице</a>
        </div>
    </div>
	</body>
</html>
