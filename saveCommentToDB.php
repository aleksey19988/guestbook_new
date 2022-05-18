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
    $fileData = $_FILES['file-input'];
    $processedFileData = [];

    if ($fileData['error'] == 0) {

        $file_ext = explode('.', $fileData['name']);
        $processedFileData['name'] = $fileData['name'];
        $processedFileData['size'] = $fileData['size'];
        $processedFileData['tmp'] = $fileData['tmp_name'];
        $processedFileData['type'] = $fileData['type'];
        $processedFileData['ext'] = strtolower(end($file_ext));

    } elseif ($fileData['error'] !== 0 && $fileData['error'] !== 4) {
        // TODO Реализовать отображение ошибки при загрузке файла
        // 0 - когда файл успешно загружен во временную директорию, 4 - когда файл не был прикреплён при отправке формы
        $errorCode = $fileData['error'];
        print_r("Ошибка при загрузке файла. Код ошибки: {$errorCode}\n");
        print_r("<a href='https://www.php.net/manual/ru/features.file-upload.errors.php' class='reset-filter-link' target='_blank'><button class='btn btn-primary' type='button'>Документация</button></a>");
        print_r("<a href='./' class='reset-filter-link'><button class='btn btn-primary' type='button'>Вернуться на главную</button></a>");
        die();
    }

    $comment = new Comment($userName, $email, $homePage, $text, $ipAddress, $browser, $dateAdded, $processedFileData);

    $result = $comment->saveCommentToDB();

    if (!$result['saveStatus']) {
        //TODO Добавить отображение ошибки если данные не записались в БД.
        $errorsForRequest = [];
        for ($i = 0; $i < count($result['errors']); $i++) {
            $errorValue = $result['errors'][$i];
            $errorsForRequest[] = "error{$i}=$errorValue";
        }
//        $errorsInStr = implode('&', $errorsForRequest);
//        header("Location: ./404/404.php?$errorsInStr");
        echo json_encode(array('result' => false, 'errors' => $errorsForRequest));
    } else {
//        header('Location: ./success.html');
        echo json_encode(array('result' => true));
    }
} else {
    print_r('Заполнены не все обязательные поля');
}