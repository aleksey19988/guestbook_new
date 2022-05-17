<?php
require_once 'Content.php';

$searchParameter = htmlspecialchars($_GET['search-parameter']);
$searchValue = htmlspecialchars($_GET['search-value']);

header("Location: ./?search-parameter=$searchParameter&search-value=$searchValue");
