<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);


if(!file_exists('config.php')) header('Location: install/index.php');
//if($_GET['page'] == 'login' || $_GET['page'] == 'login/') header("Location: ../index.php");

session_start();

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

//define('STYLES', ROOT . 'contents/themes/' . $sets['theme'] . '/assets/css/');

define('SETTINGS', serialize($settings));
define('SETS', serialize($sets));
define('STYLES', "contents/themes/" . $sets['theme'] . "/assets/css/");

if($page == '') $page = '/';

$routes_file = file('routes.txt');

foreach($routes_file as $routes_string){
    $routes_string_f = str_replace([' ', '\n'],'', $routes_string);
    if($routes_string_f == '') continue;
    $r = explode('=', trim($routes_string_f));
    $routes[trim($r[0])] = trim($r[1]);
    foreach($routes as $route => $page_id_access){
        $page_arr = explode(":", $page_id_access);
        $page_id = $page_arr[0];
        if($route == $page || $route . '/' == $page){
            switch($page_id){
                case('login'):
                    require_once('functions.php');
                    require_once(THEMES . $sets['theme'] . '/login.php');
                    $check = true;
                    break(3);
                case('account'):
                    require_once('functions.php');
                    require_once(THEMES . $sets['theme'] . '/account.php');
                    $check = true;
                    break(3);
                case('admin'):
                    if(!isset($_SESSION['id'])){
                        $settings['route'] = $route;
                        require_once('functions.php');
                        require_once(THEMES . $sets['theme'] . '/login.php');
                        $check = true;
                        break(3);
                    }
                    elseif($_SESSION['id'] != 1){
                        include_once(THEMES . $sets['theme'] . '/404.php');   
                        $check = true;
                        break(3);
                    }

                    require_once('functions.php');
                    require_once('admin/index.php');
                    $check = true;
                    break(3);
                        
            }
            $page_access = $page_arr[1];
            if($page_access == "auth"){
                if(!isset($_SESSION['id'])){
                    $settings['route'] = $route;
                    require_once('functions.php');
                    require_once(THEMES . $sets['theme'] . '/login.php');
                    $check = true;
                    die('1');
                    break(2);
                }
            }
            $page_id = (int)$page_id;
            $_SESSION['page_id'] = $page_id;
            require_once('functions.php');
            require_once(THEMES . $sets['theme'] . '/index.php');
            $check = true;
            break(2);
        }

    }
}

if($check == false) include_once(THEMES . $sets['theme'] . '/404.php');
