<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);


if(!file_exists('config.php')) header('Location: install/index.php');


define('ROOT', getcwd() . '/');
define('CORE', ROOT . 'core/');
define('MODULES', ROOT . 'modules/');
define('TESTS', ROOT . 'tests/');
define('THEMES', ROOT . 'contents/themes/');

if(!isset($_GET['page'])) $_GET['page'] = '/';
$page = $_GET['page'];
$check = false;
$settings = require(ROOT . 'config.php');
$sets_file = file(ROOT . 'sets.txt');
require('db.php');

foreach($sets_file as $set){
    $set_f = explode('=', $set);
    $sets[trim($set_f[0])] = trim($set_f[1]);
}

if($page == '') $page = '/';

$routes_file = file('routes.txt');

foreach($routes_file as $routes_string){
    $routes_string_f = str_replace([' ', '\n'],'', $routes_string);
    if($routes_string_f == '') continue;
    $r = explode('=', trim($routes_string_f));
    $routes[trim($r[0])] = trim($r[1]);
    foreach($routes as $route => $page_id){
        if($route == $page){
            $page_id = (int)$page_id;
            require('functions.php');
            require(THEMES . $sets['theme'] . '/index.php');
            $check = true;
        }

    }
}

if($check == false) include_once(THEMES . $sets['theme'] . '/404.php');
