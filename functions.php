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
 *
 * user's functions
 *
 */

/*
 * function that return site's title
 */
function get_title($page_id = 1, $settings){
    connectDB($settings);

    $pdo = DB::getDB();
    
    $stmt = $pdo->query("SELECT `title` FROM `pages` WHERE id = $page_id");
    $result = $stmt->fetch();
    unset($pdo);
    return $result['title'];

}

/*
 * function that return site's text
 */
function get_text($page_id = 1, $settings){
    connectDB($settings);

    $pdo = DB::getDB();
    
    $stmt = $pdo->query("SELECT `text` FROM `pages` WHERE id = $page_id");
    $result = $stmt->fetch();
    if($result == false) die('error');
    unset($pdo);
    return $result['text'];

}

/*
 * function that return author's data
 */
function get_author($page_id = 1, $settings){
    connectDB($settings);

    $pdo = DB::getDB();

    $stmt = $pdo->prepare("SELECT * FROM `pages` INNER JOIN `users` ON pages.author_id = users.id WHERE pages.id = ?");

    $stmt->execute([$page_id]);

    foreach($stmt as $row){
        unset($pdo);
        return new class($row){

            public
                $login,
                $id,
                $access;
            public function __construct($row){
                $this->login  = $row['login'];
                $this->id     = $row['author_id'];
                $this->access = $row['access'];
            }
            
            function __get($name){
                return "Вызвано несуществующее свойство: " . $name;
            }
        };
    }

    unset($pdo);
    return 'Автор не найден';
}

/*
 * function that make a login form
 */
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
                if(isset($settings['route'])){
                    $route = $settings['route'];
                    header("Location: $route");
                    die();
                }
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

/*
 * function that return data of current user
 */
function get_user($settings){
    if(isset($_SESSION['id'])){
        connectDB($settings);

        $pdo = DB::getDB();

        try{
            $stmt = $pdo->prepare("SELECT * FROM `users` WHERE id = ?");
            $stmt->execute([$_SESSION['id']]);
            foreach($stmt as $row){
                return new class($row){
                    public 
                        $id,
                        $login,
                        $access;

                    function __construct($row){
                        $this->id     = $row['id'];
                        $this->login  = $row['login'];
                        $this->access = $row['access'];
                    }
                    function __get($name)
                    {
                        return "Вызвано несуществующее свойство $name";
                    }

                    function __toString(){
                        return 'id=' . $this->id . " login=" . $this->login . " access-lavel=" . $this->access;
                    }

                };
            }
            throw new PDOException('Пользователь не найден');
        }
        catch(PDOException $e){
            unset($pdo);
            return $e->getMessage();
        }

        unset($pdo);
        return $row;
    }
    else {
        unset($pdo);
        header("Location: ../login");
    }
}

/*
 * generation of url
 */

function url($url){
    return new class($url){
        private $url, $protocol;
        function __construct($url){
            $this->protocol = isset($_SERVER['HTTPS']) ? "https" : "http";        
            $this->url = $url;
        }
        public function __toString(){
            return "$this->protocol://$_SERVER[HTTP_HOST]/$this->url";           
        }
        public function current(){
            return "$this->protocol://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]$this->url";           
        }
    };

}

/*
 * function that enqueues styles
 */
function styles($links = []){
    $styles = STYLES;
    if(is_string($links)){
        echo "<link rel='stylesheet' href='$styles$links'>";
        return;
    }
    foreach($links as $link){
        echo "<link rel='stylesheet' href='$link'>\n";
    }
    return;

}
