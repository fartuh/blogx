<?php

session_start();

if(isset($_SESSION['step']) && $_SESSION['step'] != 'db') header("Location: " . $_SESSION['step'] . ".php");

$_SESSION['step'] = 'db';

if(isset($_POST['name']) && isset($_POST['db']) && isset($_POST['user']) && isset($_POST['pass']) && isset($_POST['host'])){

    $name = trim($_POST['name']);
    $db   = trim($_POST['db']);
    $user = trim($_POST['user']);
    $pass = trim($_POST['pass']);
    $host = trim($_POST['host']);

    $_SESSION['name'] = $name;
    $_SESSION['db']   = $db;
    $_SESSION['user'] = $user;
    $_SESSION['pass'] = $pass;
    $_SESSION['host'] = $host;

    if($name != '' && $db != '' && $user != '' && $pass != '' && $host != ''){
        require_once('make.php');
        header("Location: login.php");
    }

}

?>


<!DOCTYPE html>
<html lang="ru">
<head>
    <link rel="stylesheet" href="styles/main.css">
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
    <div class="container">
        <form class="form" method="POST" action="">
            <label class="form__label" for="name">Название вашей игры</label><br/>
            <input name="name" id="name" class="form__input-text" value="<?php if(isset($_SESSION['name'])) echo $_SESSION['name'] ?>" type="text"><br/>

            <label class="form__label" for="db">Название базы данных</label><br/>
            <input name="db" id="db" class="form__input-text" value="<?php if(isset($_SESSION['name'])) echo $_SESSION['db'] ?>" type="text"><br/>

            <label class="form__label" for="user">Имя пользователя БД</label><br/>
            <input name="user" id="user" class="form__input-text" value="<?php if(isset($_SESSION['name'])) echo $_SESSION['user'] ?>" type="text"><br/>

            <label class="form__label" for="pass">Пароль пользователя БД</label><br/>
            <input name="pass" id="pass" class="form__input-text" value="<?php if(isset($_SESSION['name'])) echo $_SESSION['pass'] ?>" type="text"><br/>

            <label class="form__label" for="host">Host базы данных</label><br/>
            <input name="host" id="host" class="form__input-text" value="localhost" type="text"><br/>

            <input name="submit" class="form__input-submit" value="Дальше" type="submit">
 </form>
    </div>
</body>
</html>
