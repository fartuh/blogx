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

function cr($string){
    return sha1($string);
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

function login_form($settings, $classes=['pass' => '', 'login' => '', 'labels' => '']){
    if(isset($_SESSION['id'])) header("Location: account/");
    if(isset($_POST['sub']) && isset($_POST['login']) && isset($_POST['pass'])){
        $login = trim($_POST['login']);
        $pass  = cr(trim($_POST['pass']));
        $count_ = 0;

        connectDB($settings);
        $pdo = DB::getDB();

        $stmt = $pdo->prepare("SELECT * FROM `users` WHERE login = ?");
        $stmt->execute([$login]);
        foreach($stmt as $row){
            if($row['password'] == $pass){
                $_SESSION['id'] = $row['id'];
                //$count_ = 1;
                header("Location: account/");
            }
        }
        if($count_ != 1){
                echo "Ошибка авторизации";
                unset($_POST);
                login_form($settings, $classes);
        }

        die();
    }
    $login = $classes['login'];
    $pass = $classes['pass'];
    $labels = $classes['labels'];
    echo "
        <form action='' method='post'>

            <label for='login' class='$labels'>Ваш login</label><br/>
            <input type='text' id='login' class='$login' name='login'><br/>
            <label for='pass' class='$labels'>Ваш password</label><br/>
            <input type='password' id='pass' class='$pass' name='pass'><br/>
            <label for='pass'></label><br/>
            <input type='submit' name='sub'>

        </form>
         ";
}
