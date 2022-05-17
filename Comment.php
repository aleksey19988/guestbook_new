<?php
require_once 'DBconnect.php';

class Comment
{
    private string $userName;
    private string $email;
    private string $homepage;
    private string $text;
    private string $ipAddress;
    private string $browser;
    private string $dateAdded;
    private array $fileData;
    private array $acceptImgFormats = ['jpg', 'gif', 'png'];
    private array $acceptFileFormats = ['txt'];
    private string $fileDirectory = 'files';

    /**
     * @param string $userName
     * @param string $email
     * @param string $homepage
     * @param string $text
     * @param string $ipAddress
     * @param string $browser
     * @param string $dateAdded
     * @param $fileData
     */
    public function __construct(string $userName, string $email, string $homepage, string $text, string $ipAddress, string $browser, string $dateAdded, $fileData)
    {
        $this->userName = $userName;
        $this->email = $email;
        $this->homepage = $homepage;
        $this->text = $text;
        $this->ipAddress = $ipAddress;
        $this->browser = $browser;
        $this->dateAdded = $dateAdded;
        $this->fileData = $fileData;
    }

    /**
     * @return array
     */
    public function getAllProperties(): array
    {
        return [
            'userName' => $this->userName,
            'email' => $this->email,
            'homePage' => $this->homepage,
            'text' => $this->text,
            'ipAddress' => $this->ipAddress,
            'browser' => $this->browser,
            'dateAdded' => $this->dateAdded,
        ];
    }

    /**
     * @return string
     */
    public function getUserName(): string
    {
        return $this->userName;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getHomePage(): string
    {
        return $this->homepage;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @return string
     */
    public function getIpAddress(): string
    {
        return $this->ipAddress;
    }

    /**
     * @return string
     */
    public function getBrowser(): string
    {
        return $this->browser;
    }

    /**
     * @return string
     */
    public function getDateAdded(): string
    {
        return $this->dateAdded;
    }

    /**
     * @return array
     */
    public function getFileData(): array
    {
        return $this->fileData;
    }

    public function getFileDirectory(): string
    {
        return $this->fileDirectory;
    }

    public function getImageSize(): array
    {
        $fileData = $this->getFileData();
        return [
            'width' => getimagesize($fileData['tmp'])[0],
            'height' => getimagesize($fileData['tmp'])[1],
        ];
    }

    public function checkFile($fileData): array
    {
        $errors = [];

        $fileExt = $fileData['ext'];
        if (in_array($fileExt, $this->acceptImgFormats)) {
            $imageSize = $this->getImageSize();

            if ($fileData['size'] > 1000000) {
                $errors[] = "Слишком большой вес картинки (max 1 MB)!\n";
            }
            if ($imageSize['height'] > 240) {
                $errors[] = "Слишком высокая картинка (высота превышает допустимую 240px)!\n";
            }
            if ($imageSize['width'] > 320) {
                $errors[] = "Слишком широкая картинка (ширина превышает допустимую 320px)!\n";
            }

        } elseif (in_array($fileExt, $this->acceptFileFormats)) {
            if ($fileData['size'] > 100000) {
                $errors[] = "Слишком большой текстовый файл (max 100 KB)!\n";
            }
        } else {
            $errors[] = 'Недопустимый формат файла!\n';
        }

        return $errors;
    }

    public function saveCommentToDB(): bool
    {

        $connection = DBconnect::connectToDB();
        //Проверяем на соответствие вложенный файл
        $fileErrors = $this->checkFile($this->getFileData());

        if (empty($fileErrors)) {
            //Подготовили запрос
            $query = "INSERT INTO comments (name, email, homepage, text, user_browser, ip_address, date_added, path_to_file) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $prepare = $connection->prepare($query);

            //Сохраняем файл в папке files
            $fileDirectory = $this->getFileDirectory();
            $currentDirectory = $_SERVER['DOCUMENT_ROOT'];
            $fileName = $this->getFileData()['name'];
            $moveFileResult = move_uploaded_file($this->getFileData()['tmp'], "$currentDirectory/$fileDirectory/$fileName");

            //Сохраняем данные в БД
            if ($moveFileResult) {
                return $prepare->execute([$this->getUserName(), $this->getEmail(), $this->getHomePage(), $this->getText(), $this->getBrowser(), $this->getIpAddress(), $this->getDateAdded(), "$currentDirectory/$fileDirectory/$fileName"]);
            } else {
                return false;
            }
        } else {
            //TODO Реализовать отображение ошибок с прикрепленным файлом
        }
    }
}
