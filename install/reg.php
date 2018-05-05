<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

require('../db.php');
require('../functions.php');

use CMS\DB;

$host = $settings['host'];
$db = $settings['db'];

connectDB($settings);

//make a admin account
try{
    $pdo = DB::getDB();

    $stmt = $pdo->prepare("INSERT INTO `users`(login, password, access) VALUES(?,?,'admin')");

    $stmt->execute([$login, cr($user_pass)]);
}
catch(PDOException $e){
    echo 'Произошла ошибка: ' . $e->getMessage() . "<br/>";
    echo "<a href='index.php'>Изменить данные</a>";
    if(file_exists('../config.php')) unlink('../config.php');
    die();
}

try{
    $pdo = DB::getDB();

    $name = get_option('name', $settings);

    $stmt = $pdo->prepare("INSERT INTO `pages`(title, text, author_id) VALUES(?,?,1)");

    
    $stmt->execute([$name, 'Это главная страница вашего сайта. Редактировать её содержание вы можете авторизовавшись в аккаунт администратора <a href="login">здесь</a>']);
}
catch(PDOException $e){
    echo 'Произошла ошибка: ' . $e->getMessage() . "<br/>";
    echo "<a href='index.php'>Изменить данные</a>";
    if(file_exists('../config.php')) unlink('../config.php');
    die();
}
