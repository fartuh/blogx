<?php

use CMS\DB;

function get_title($page_id = 1, $settings = []){
    $host = $settings['host'];
    $db = $settings['db'];

    $dsn = "mysql:host=$host;dbname=$db;charset=utf8";
    try{
        DB::connectDB($dsn, $settings['user'], $settings['pass']);
    }

    catch(PDOException $e)
    {
    }

    $pdo = DB::getDB();
    
    $stmt = $pdo->query("SELECT `title` FROM `pages` WHERE id = $page_id");
    $result = $stmt->fetch();
    return $result['title'];

}

function get_text($page_id = 1, $settings = []){
    $host = $settings['host'];
    $db = $settings['db'];

    $dsn = "mysql:host=$host;dbname=$db;charset=utf8";
    try{
        DB::connectDB($dsn, $settings['user'], $settings['pass']);
    }

    catch(PDOException $e)
    {
    }

    $pdo = DB::getDB();
    
    $stmt = $pdo->query("SELECT `text` FROM `pages` WHERE id = $page_id");
    $result = $stmt->fetch();
    if($result == false) die('error');
    return $result['text'];

}

function get_author($page_id = 1, $settings = []){
    $host = $settings['host'];
    $db = $settings['db'];

    $dsn = "mysql:host=$host;dbname=$db;charset=utf8";
    try{
        DB::connectDB($dsn, $settings['user'], $settings['pass']);
    }

    catch(PDOException $e)
    {
    }

    $pdo = DB::getDB();
    
    //will be sooner
}
