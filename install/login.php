<?php

session_start();

if(!isset($_SESSION['step']) || $_SESSION['step'] != 'login') header("Location: index.php");

if(isset($_POST['login']) && isset($_POST['user_pass'])){

    $login = trim($_POST['login']);
    $user_pass   = trim($_POST['user_pass']);

    $_SESSION['login'] = $user;
    $_SESSION['user_pass'] = $user_pass;

    if($login != '' && $user_pass != ''){
        require_once('reg.php');
        header("Location: ../index.php");
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
            <label class="form__label" for="login">Login администратора</label><br/>
            <input name="login" id="login" class="form__input-text" value="<?php if(isset($_SESSION['login'])) echo $_SESSION['login'] ?>" type="text"><br/>

            <label class="form__label" for="user_pass">Пароль администратора</label><br/>
            <input name="user_pass" id="user_pass" class="form__input-text" value="" type="text"><br/>

            <input name="submit" class="form__input-submit" value="Дальше" type="submit">
 </form>
    </div>
</body>
</html>
