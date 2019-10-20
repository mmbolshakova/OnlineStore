<?php

session_start();
require_once('./private/main.php');
require_once('./private/lib.php');
if ($_POST['login'] && $_POST['mail'] && $_POST['teleph'] && $_POST['pass'])
{
    if ($_POST['super'] == $_MAIN['adminpass'])
        $super = 1;
    else
        $super = 0;
    $_MAIN['usr'] = get_file('./data/usr');
    if (get_file('./data/usr') != [])
    {
        foreach ($_MAIN['usr'] as $key => $value)
        {
            if ($value['login'] === $_POST['login'])
            {
                $flag = 1;
                $_MAIN['msg_err'] = 'Такой пользователь уже существует';
            }
        }
    }
    $user  = [
        'id' => count($_MAIN['usr']),
        'login' => $_POST['login'],
        'mail' => $_POST['mail'],
        'teleph' => $_POST['teleph'],
        'pass' => hash("md5", $_POST['pass']),
        'admin' => $super
    ];
    if (!$flag)
    {
        $_MAIN['usr'][] = $user;
        $_SESSION['usr'] = $user;
        update_file('./data/usr', $_MAIN['usr']);
        header('Location: index.php');
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
    <form action="reg.php" method="post" class="m-auto" style="max-width: 800px">
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
                    <input type="text" class="form-control" id="login" name="login" placeholder="Придумайте логин">
                </div>
                <div class="form-group">
                    <label for="mail">E-mail</label>
                    <input type="email" class="form-control" id="mail" name="mail" placeholder="Напишите свой e-mail">
                    <small id="emailHelp" class="form-text text-muted">Мы никому не передадим вашу почту</small>
                </div>
                <div class="form-group">
                    <label for="teleph">Номер телефона</label>
                    <input type="tel" class="form-control" id="teleph" name="teleph" aria-describedby="telHelp" pattern="7[0-9]{10}" placeholder="7XXXXXXXXXX">
                </div>
                <div class="form-group">
                    <label for="pass">Пароль</label>
                    <input type="password" class="form-control" id="pass" name="pass" placeholder="Придумайте пароль">
                </div>
                <div class="form-group">
                    <label for="super">Пароль администратора</label>
                    <input type="password" class="form-control" id="super" name="super" placeholder="Введите секретный пароль">
                    <small id="superHelp" class="form-text text-muted">Если вы хотите зарегистрироваться как администратор, введите секретный пароль</small>
                </div>
                <button type="submit" name="submit" class="btn btn btn-outline-info">Зарегистрироваться</button>
                <a href="login.php" class="btn btn-link text-info ml-3" role="button" aria-pressed="true">Уже есть логин</a>
                <a href="index.php" class="btn btn-link text-info ml-3" role="button" aria-pressed="true">На главную</a>
            </form>
        </div>
</div>
</body>
</html>