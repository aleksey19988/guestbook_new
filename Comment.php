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

    /**
     * @param string $userName
     * @param string $email
     * @param string $homepage
     * @param string $text
     * @param string $ipAddress
     * @param string $browser
     * @param string $dateAdded
     */
    public function __construct(string $userName, string $email, string $homepage, string $text, string $ipAddress, string $browser, string $dateAdded)
    {
        $this->userName = $userName;
        $this->email = $email;
        $this->homepage = $homepage;
        $this->text = $text;
        $this->ipAddress = $ipAddress;
        $this->browser = $browser;
        $this->dateAdded = $dateAdded;
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

    public function saveCommentToDB() {
        $connection = DBconnect::connectToDB();
        $query = "INSERT INTO comments (name, email, homepage, text, ip_address, user_browser, date_added) VALUES ('$this->userName', '.$this->email', '$this->homepage', '$this->text', '$this->ipAddress', '$this->browser', '$this->dateAdded')";
        $result = $connection->query($query);

        return !(($result === false));
    }
}