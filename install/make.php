<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

require('../db.php');

use CMS\DB;

$dsn = "mysql:host=$host;dbname=$db;charset=utf8";
try{
    DB::connectDB($dsn, $user, $pass);
}
catch(PDOException $e)
{
    echo $e->getMessage() . "<br />";
    echo "<a href='index.php'>Изменить данные</a>";
    die();
}

$_SESSION['step'] = 'login';

$f = fopen('../config.php', 'w');
fwrite($f, '<?php 
');
fwrite($f, 'return [ 
');
fwrite($f, "'user' => '$user', \n");
fwrite($f, "'pass' => '$pass', \n");
fwrite($f, "'host' => '$host', \n");
fwrite($f, "'db' => '$db' \n");
fwrite($f, ']');

fclose($f);

try{
    $pdo = DB::getDB();

    $table_users = $pdo->prepare(
    "CREATE TABLE `users` ( `id` INT NOT NULL AUTO_INCREMENT , `login` VARCHAR(100) NOT NULL , `password` VARCHAR(100) NOT NULL , `access` INT NOT NULL DEFAULT '2' , PRIMARY KEY (`id`), UNIQUE (`login`) ) ENGINE = InnoDB");

    $bool = $table_users->execute();

    if(!$bool) throw new PDOException('Невозможно создать таблицу users в базе данных');

}
catch(PDOException $e){
    echo 'Произошла ошибка:' . $e->getMessage();
    die();
}
