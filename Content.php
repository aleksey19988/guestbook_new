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

    public function getCommentsWithPaging($page = 1, $sortParameter = null, $direction = null): array
    {
        $sortParameter = htmlspecialchars($_GET['sort']) ?? false;
        $direction = htmlspecialchars($_GET['direction']) ?? false;
        $page = $_GET['page'] ?? $page;
        settype($page, "integer");
        $offset = ($page > 1) ? $this->commentsCountOnPage * ($page - 1) : 0;

        $connection = DBconnect::connectToDB();

        if ($sortParameter && $direction) {
            $query = "SELECT * FROM comments ORDER BY {$sortParameter} {$direction} LIMIT {$offset}, {$this->commentsCountOnPage}";
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
        } else {
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
        $this->showTableHead(htmlspecialchars($_GET['direction']));

        $comments = $this->getCommentsWithPaging($_GET['page'], $_GET['sort'], $_GET['direction']);
        $counter = ($_GET['page'] == 1 || $_GET['page'] === null) ? 1 : ((htmlspecialchars($_GET['page']) - 1) * $this->commentsCountOnPage + 1);

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
        return ceil(count($this->getAllComments()) / $this->commentsCountOnPage);
    }

    public function showPagesLinks($pagesCount)
    {
        $pagesCount = $this->getPagesCount();
        $sortParameter = htmlspecialchars($_GET['sort']) ?? false;
        $direction = htmlspecialchars($_GET['direction']) ?? false;

        for ($i = 1; $i <= $pagesCount; $i++) {
            if ($sortParameter && $direction) {
                $link = "<a href=?page={$i}&sort={$sortParameter}&direction={$direction}><button class='page-button'>{$i}</button></a>";
            } else {
                $link = "<a href=?page={$i}><button class='page-button'>{$i}</button></a>";
            }

            print_r($link);
        }
    }
}