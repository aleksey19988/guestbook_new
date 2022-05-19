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
            print_r($fileData['size']);
            if ($fileData['size'] > 1000000) {
                $size = round($fileData['size'] / 1000000, 2);
                $errors[] = "Максимальный вес картинки может составлять не более 1 МБ (вес текущей картинки - {$size} МБ)!";
            }
            if ($imageSize['height'] > 240) {
                $height = $imageSize['height'];
                $errors[] = "Максимальная высота картинки может составлять 240px (высота текущей картинки составляет {$height}px)!";
            }
            if ($imageSize['width'] > 320) {
                $width = $imageSize['width'];
                $errors[] = "Максимальная ширина картинки может составлять 320px (ширина текущей картинки составляет {$width}px)!";
            }

        } elseif (in_array($fileExt, $this->acceptFileFormats)) {
            if ($fileData['size'] > 100000) {
                $errors[] = "Слишком большой текстовый файл (max 100 KB)!";
            }
        } else {
            $errors[] = "Недопустимый формат файла!";
        }

        return $errors;
    }

    public function saveCommentToDB(): array
    {
        $connection = DBconnect::connectToDB();

        if (!empty($this->getFileData())) {
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
                    $savedStatus = $prepare->execute([$this->getUserName(), $this->getEmail(), $this->getHomePage(), $this->getText(), $this->getBrowser(), $this->getIpAddress(), $this->getDateAdded(), "$currentDirectory/$fileDirectory/$fileName"]);
                    if ($savedStatus) {
                        return [
                            'saveStatus' => true,
                            'errors' => []
                        ];
                    } else {
                        return [
                            'saveStatus' => false,
                            'errors' => ['Ошибка сохранения данных в БД. Проверьте запросы/настройки БД (в форме был прикреплённый файл)'],
                        ];
                    }
                } else {
                    return [
                        'saveStatus' => false,
                        'errors' => ['Ошибка сохранения файла в файловую систему. Проверьте запросы/пути сохранения файла'],
                    ];
                }
            } else {
                return [
                    'saveStatus' => false,
                    'errors' => $fileErrors,
                ];
            }
        } else {
            //Подготовили запрос
            $query = "INSERT INTO comments (name, email, homepage, text, user_browser, ip_address, date_added, path_to_file) VALUES (:name, :email, :homepage, :text, :user_browser, :ip_address, :date_added, :path_to_file)";
            $prepare = $connection->prepare($query);
            var_dump($prepare);
            $savedStatus = $prepare->execute(array(
                ':name' => $this->getUserName(),
                ':email' => $this->getEmail(),
                ':homepage' => $this->getHomePage(),
                ':text' => $this->getText(),
                ':user_browser' => $this->getBrowser(),
                ':ip_address' => $this->getIpAddress(),
                ':date_added' => $this->getDateAdded(),
                ':path_to_file' => '',
                )
            );
            var_dump($savedStatus);
            if ($savedStatus) {
                return [
                    'saveStatus' => true,
                    'errors' => []
                ];
            } else {
                return [
                    'saveStatus' => false,
                    'errors' => ['Ошибка сохранения данных в БД. Проверьте запросы/настройки БД (файл в форме отсутствовал)'],
                ];
            }
        }
    }
}
