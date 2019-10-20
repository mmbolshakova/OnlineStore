<?php

session_start();
require_once('./private/main.php');
require_once('./private/lib.php');

if (isset($_POST['login']) && isset($_POST['pass']))
{
    $_MAIN['usr'] = get_file('./data/usr');
    $user = get_user($_MAIN['usr'], $_POST['login'], hash("md5", $_POST['pass']));
    if ($user)
    {
        header('Location: index.php');
        $_SESSION['usr'] = $user;
    }
    else
    {
        $_MAIN['msg_err'] = "Неправильно введен логин или пароль";
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="style.css">
    <title><?=$_MAIN['mag_name']?></title>
</head>
<body>
<div class="mt-5">
    <form action="login.php" method="post" class="m-auto" style="max-width: 800px">
        <?php if ($_MAIN['msg_ok']): ?>
            <div class="alert alert-info" role="alert">
                <?=$_MAIN['msg_ok']?>
            </div>
        <?php endif ?>
        <?php if ($_MAIN['msg_err']): ?>
            <div class="alert alert-danger" role="alert">
                <?=$_MAIN['msg_err']?>
            </div>
        <?php endif ?>
        <div class="container border py-4">
            <form>
                <div class="form-group">
                    <label for="login">Логин</label>
                    <input type="text" class="form-control" id="login" name="login" placeholder="Введите логин">
                </div>
                <div class="form-group">
                    <label for="pass">Пароль</label>
                    <input type="password" class="form-control" id="pass" name="pass" placeholder="Введите пароль">
                </div>
                <button type="submit" name="submit" class="btn btn btn-outline-info">Войти</button>
                <a href="reg.php" class="btn btn-link text-info ml-3" role="button" aria-pressed="true">Зарегестрироваться</a>
                <a href="index.php" class="btn btn-link text-info ml-3" role="button" aria-pressed="true">На главную</a>
            </form>
        </div>
</div>
</body>
</html>