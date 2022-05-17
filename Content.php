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

    public function getSortedComments($page = 1, $sortParameter = null, $direction = null): array
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

    public function getFilteredComments($searchParameter, $searchValue): array
    {
        $connection = DBconnect::connectToDB();
        $query = "SELECT * FROM comments WHERE {$searchParameter} LIKE '%{$searchValue}%'";

        return $connection->query($query)->fetchAll();
    }

    public function getColumnsHeads(): array
    {
        $result = [];
        $connection = DBconnect::connectToDB();
        $columns = $connection->query('SHOW COLUMNS FROM comments')->fetchAll();

        foreach ($columns as $elem) {
            foreach ($elem as $key => $value) {
                if ($key === 'Field') {
                    $result[] = $value;
                }
            }
        }

        return $result;
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
        $tableHead = $this->getColumnsHeads();

        foreach ($tableHead as $elem) {
            if (in_array($elem, $sortedFields)) {
                $thead .= "<th scope='col'><a href=?sort={$elem}&direction={$sortedDirection}>{$elem}</a></th>";
            } else {
                $thead .= "<th scope='col'>{$elem}</th>";
            }
        }

        print_r("<thead>{$thead}</thead>");
    }

    public function showComments()
    {
        $this->showTableHead(htmlspecialchars($_GET['direction']));

        if ($_GET['search-parameter'] && $_GET['search-value']) {
            $comments = $this->getFilteredComments($_GET['search-parameter'], $_GET['search-value']);
        } else {
            $comments = $this->getSortedComments($_GET['page'], $_GET['sort'], $_GET['direction']);
        }
        $rowNum = ($_GET['page'] == 1 || $_GET['page'] === null) ? 1 : ((htmlspecialchars($_GET['page']) - 1) * $this->commentsCountOnPage + 1);

        foreach ($comments as $comment) {
            $row = "<td>$rowNum</td>";
            foreach ($comment as $key => $value) {
                if ($key === 'id') {
                    continue;
                } elseif (gettype($key) === 'string') {
                    $row .= "<td>$value</td>";
                }
            }
            print_r("<tr>{$row}</tr>");
            $rowNum++;
        }
    }

    public function getPagesCount(): int
    {
        if ($_GET['search-parameter'] && $_GET['search-value']) {
            return ceil(count($this->getFilteredComments($_GET['search-parameter'], $_GET['search-value'])) / $this->commentsCountOnPage);
        } else {
            return ceil(count($this->getAllComments()) / $this->commentsCountOnPage);
        }
    }

    public function showPagesLinks($pagesCount)
    {
        $pagesCount = $pagesCount ?? $this->getPagesCount();
        $sortParameter = htmlspecialchars($_GET['sort']) ?? false;
        $direction = htmlspecialchars($_GET['direction']) ?? false;
        $searchParameter = htmlspecialchars($_GET['search-parameter']) ?? false;
        $searchValue = htmlspecialchars($_GET['search-value']) ?? false;
        $currentPage = null;

        if ($_GET['page'] == null || $_GET['page'] == 1) {
            $currentPage = 1;
        } else {
            $currentPage = $_GET['page'];
        }

        for ($i = 1; $i <= $pagesCount; $i++) {
            $currentPageClass = ($currentPage == $i) ? 'current-page' : '';
            if ($searchParameter
                && $searchValue
                && $sortParameter
                && $direction) {
                $link = "<a href=?page={$i}&sort={$sortParameter}&direction={$direction}&search-parameter={$searchParameter}&search-value={$searchValue}><button class='page-button {$currentPageClass}'>{$i}</button></a>";
            } elseif ($sortParameter && $direction) {
                $link = "<a href=?page={$i}&sort={$sortParameter}&direction={$direction}><button class='page-button {$currentPageClass}'>{$i}</button></a>";
            } elseif ($searchParameter && $searchValue) {
                $link = "<a href=?page={$i}&search-parameter={$searchParameter}&search-value={$searchValue}><button class='page-button {$currentPageClass}'>{$i}</button></a>";
            }
            else {
                $link = "<a href=?page={$i}><button class='page-button {$currentPageClass}'>{$i}</button></a>";
            }

            print_r($link);
        }
    }

    public function showSearchParameters()
    {
        $parameters = $this->getColumnsHeads();
        $disableParameters = ['id'];

        foreach($parameters as $elem) {
            if (in_array($elem, $disableParameters)) {
                continue;
            } else {
                print_r("<option value={$elem} name={$elem}>$elem</option>");
            }
        }
    }

}