<?php

class Comment
{
    private string $userName;
    private string $email;
    private string $homePage;
    private string $text;
    private string $ipAddress;
    private string $browser;
    private string $dateAdded;

    /**
     * @param string $userName
     * @param string $email
     * @param string $homePage
     * @param string $text
     * @param string $ipAddress
     * @param string $browser
     * @param string $dateAdded
     */
    public function __construct(string $userName, string $email, string $homePage, string $text, string $ipAddress, string $browser, string $dateAdded)
    {
        $this->userName = $userName;
        $this->email = $email;
        $this->homePage = $homePage;
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
            'homePage' => $this->homePage,
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
        return $this->homePage;
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
}