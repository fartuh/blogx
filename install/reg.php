<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

require('../db.php');

use CMS\DB;

print_r($settings);

$host = $settings['host'];
$db = $settings['db'];

$dsn = "mysql:host=$host;dbname=$db;charset=utf8";
try{
    DB::connectDB($dsn, $settings['user'], $settings['pass']);
}
catch(PDOException $e)
{
    echo 'Произошла ошибка: ' . $e->getMessage() . "<br/>";
    echo "<a href='index.php'>Изменить данные</a>";
    if(file_exists('../config.php')) unlink('../config.php');
    die();
}

//make a admin account
try{
    $pdo = DB::getDB();

    $stmt = $pdo->prepare("INSERT INTO `users`(login, password, access) VALUES(?,?,1)");

    $stmt->execute([$login, md5($user_pass)]);
}
catch(PDOException $e){
    echo 'Произошла ошибка: ' . $e->getMessage() . "<br/>";
    echo "<a href='index.php'>Изменить данные</a>";
    if(file_exists('../config.php')) unlink('../config.php');
    die();
}

try{
    $pdo = DB::getDB();

    $stmt = $pdo->prepare("INSERT INTO `pages`(title, text, author_id) VALUES(?,?,1)");

    $stmt->execute([$settings["name"], 'Это главная страница вашего сайта. Редактировать её содержание вы можете перейдя в <a href="admin/">админ-панель</a>']);
}
catch(PDOException $e){
    echo 'Произошла ошибка: ' . $e->getMessage() . "<br/>";
    echo "<a href='index.php'>Изменить данные</a>";
    if(file_exists('../config.php')) unlink('../config.php');
    die();
}
