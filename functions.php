<?php

use CMS\DB;

function connectDB($settings){
    $host = $settings['host'];
    $db = $settings['db'];

    $dsn = "mysql:host=$host;dbname=$db;charset=utf8";
    try{
        DB::connectDB($dsn, $settings['user'], $settings['pass']);
    }

    catch(PDOException $e)
    {
    }
}
/*
 * function that return site's title
 */
function get_title($page_id = 1, $settings = []){
    connectDB($settings);

    $pdo = DB::getDB();
    
    $stmt = $pdo->query("SELECT `title` FROM `pages` WHERE id = $page_id");
    $result = $stmt->fetch();
    return $result['title'];

}

/*
 * function that return site's text
 */
function get_text($page_id = 1, $settings = []){
    connectDB($settings);

    $pdo = DB::getDB();
    
    $stmt = $pdo->query("SELECT `text` FROM `pages` WHERE id = $page_id");
    $result = $stmt->fetch();
    if($result == false) die('error');
    return $result['text'];

}

/*
 * function that return author's data
 */
function get_author($page_id = 1, $settings = []){
    connectDB($settings);

    $pdo = DB::getDB();
    
    //will be sooner
}
