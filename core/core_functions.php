<?php

use CMS\DB;

/*
 *
 * core's functions
 *
 */

/*
 * connect to db
 */
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
 * Crypting
 */
function cr($string){
    return sha1($string);
}

function get_option($key, $settings){
    connectDB($settings);

    $pdo = DB::getDB();
    try{
        $stmt = $pdo->prepare("SELECT `value` FROM `options` WHERE `key` = ?");
        $stmt->execute([$key]);
    }
    catch(PDOException $e)
    {
    }
    foreach($stmt as $row){
        return $row['value'];
    }
    return "Опция не найдена";
}

function set_option($key, $value, $settings){
    connectDB($settings);
    $pdo = DB::getDB();

    try{
        $stmt = $pdo->prepare("INSERT INTO `options` (`id`, `key`, `value`) VALUES (NULL, ?, ?)");
        $stmt->execute([$key, $value]);
        return true;
    }
    catch(PDOException $e)
    {
    }

    unset($pdo);
    return false;
}

/*
 * return array of settings
 */
function get_settings(){
    return unserialize(SETTINGS);
}
