<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

require('../db.php');

use CMS\DB;

$dsn = "mysql:host=$host;dbname=$db;charset=utf8";
try{
    DB::getDB($dsn, $user, $pass);
}
catch(PDOException $e)
{
    echo $e->getMessage() . "<br />";
    echo "<a href='index.php'>Изменить данные</a>";
    die();
}
