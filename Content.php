<?php
require_once 'DBconnect.php';

class Content
{
    public function showComments()
    {
        $connection = DBconnect::connectToDB();
        $query = 'SELECT * FROM comments';
        $comments = $connection->query($query)->fetchAll();
        $counter = 1;

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
}