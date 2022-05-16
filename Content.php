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

    public function getCommentsWithPaging($page = 1, $parameter = null, $direction = null): array
    {
        $parameter = $_GET['sort'] ?? false;
        $direction = $_GET['direction'] ?? false;
        $page = $_GET['page'] ?? $page;
        $offset = ($page > 1) ? $this->commentsCountOnPage * ($page - 1) : 0;

        $connection = DBconnect::connectToDB();

        if ($parameter && $direction) {
            $query = "SELECT * FROM comments ORDER BY {$parameter} {$direction} LIMIT {$offset}, {$this->commentsCountOnPage}";
        } else {
            $query = "SELECT * FROM comments LIMIT {$offset}, {$this->commentsCountOnPage}";
        }

        return $connection->query($query)->fetchAll();
    }

    public function showTableHead($sortedDirection = null)
    {
        $sortedFields = ['name', 'email', 'date_added'];

        if ($sortedDirection === null || $sortedDirection === 'DESC') {
            $sortedDirection = 'ASC';
        } elseif ($sortedDirection === 'ASC') {
            $sortedDirection = 'DESC';
        }

        $thead = '';
        $connection = DBconnect::connectToDB();
        $tableHead = $connection->query('SHOW COLUMNS FROM comments')->fetchAll();

        foreach ($tableHead as $elem) {
            foreach ($elem as $key => $value) {
                if ($key === 'Field') {
                    if (in_array($value, $sortedFields)) {
                        $thead .= "<th scope='col'><a href=?sort={$value}&direction={$sortedDirection}>{$value}</a></th>";
                    } else {
                        $thead .= "<th scope='col'>{$value}</th>";
                    }
                }
            }
        }

        print_r("<thead>{$thead}</thead>");
    }

    public function showComments()
    {
        $this->showTableHead($_GET['direction']);

        $comments = $this->getCommentsWithPaging();
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