<?php
require_once 'DBconnect.php';

class Content
{
    private int $commentsCountOnPage = 5;

    public function getAllComments(): array
    {
        $connection = DBconnect::connectToDB();
        $query = "SELECT * FROM comments";

        return $connection->query($query)->fetchAll();
    }

    public function getCommentsWithPaging($page = 1): array
    {
        $page = $_GET['page'] ?? $page;
        $offset = ($page > 1) ? $this->commentsCountOnPage * ($page - 1) : 0;

        $connection = DBconnect::connectToDB();
        $query = "SELECT * FROM comments LIMIT {$offset}, {$this->commentsCountOnPage}";

        return $connection->query($query)->fetchAll();
    }

    public function showTableHead()
    {
        $thead = '';
        $connection = DBconnect::connectToDB();
        $tableHead = $connection->query('SHOW COLUMNS FROM comments')->fetchAll();

        foreach ($tableHead as $elem) {
            foreach ($elem as $key => $value) {
                if ($key === 'Field') {
                    $thead .= "<th scope='col'>{$value}</th>";
                }
            }
        }

        print_r("<thead>{$thead}</thead>");
    }

    public function showComments()
    {
        $comments = $this->getCommentsWithPaging();
//        $counter = ($_GET['page'] * $this->commentsCountOnPage) ?? 1;
        $counter = ($_GET['page'] == 1 || $_GET['page'] === null) ? 1 : (($_GET['page'] - 1) * $this->commentsCountOnPage + 1);
        foreach ($comments as $comment) {
            $row = "<td>$counter</td>";
            foreach ($comment as $key => $value) {
                if ($key === 'id') {
                    continue;
                } elseif (gettype($key) === 'string') {
                    $row .= "<td>$value</td>";
                }
            }
            print_r("<tr>{$row}</tr>");
            $counter++;
        }
    }

    public function getPagesCount(): int
    {
        $pagesCount = ceil(count($this->getAllComments()) / $this->commentsCountOnPage);

        for ($i = 1; $i <= $pagesCount; $i++) {
            print_r("<a href=?page={$i}><button class='page-button'>{$i}</button></a>");
        }

        return $pagesCount;
    }
}