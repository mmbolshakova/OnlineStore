<?php
session_start();
require_once('./private/main.php');
require_once('./private/lib.php');
$_MAIN['prod'] = get_file('./data/prod');
$_MAIN['cat'] = get_file('./data/cat');
$_MAIN['usr'] = get_file('./data/usr');
$_MAIN['confirm'] = get_file('./data/confirm');

if (isset($_GET['action']) && isset($_GET['usr_id']) && $_GET['action'] == 'rem_usr' && $_GET['usr_id'] == 'me')
{
    unset($_MAIN['usr'][$_SESSION['usr']['id']]);
    update_file('./data/usr', $_MAIN['usr']);
    header('Location: logout.php');
}
else if (is_admin() && isset($_GET['action']) && isset($_GET['usr_id']) && $_GET['action'] == 'rem_usr')
{

    if (isset($_MAIN['usr'][$_GET['usr_id']]))
    {
        unset($_MAIN['usr'][$_GET['usr_id']]);
        update_file('./data/usr', $_MAIN['usr']);
        header('Location: settings.php?msg_ok=пользователь удален');
    }
    else
        header('Location: settings.php?msg_ok=ошибка');
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
<div>
    <div class="container-fluid px-5 mb-5 mt-3">
        <div class="row">
            <h1 class="m-2 mr-5">Маша Есть!</h1>
            <a href="index.php" class="btn btn-outline-info btn-lg m-2" role="button" aria-pressed="true">Все</a>
            <?php foreach ($_MAIN['cat'] as $key => $value): ?>
                <a href="index.php?catygory=<?=$key?>" class="btn btn-outline-info btn-lg m-2" role="button" aria-pressed="true"><?=$value?></a>
            <?php endforeach ?>
            <div class="ml-auto">
                <?php if (is_admin() == false): ?>
                    <a href="bag.php" class="btn btn-link text-danger" role="button" aria-pressed="true">Корзина (<?=count($_SESSION['bag'])?>)</a>
                <?php endif; ?>
                <?php if (isset($_SESSION['usr'])): ?>
                    <a href="logout.php" class="btn btn-link text-info" role="button" aria-pressed="true">Выйти</a>
                <?php else: ?>
                    <a href="login.php" class="btn btn-link text-info" role="button" aria-pressed="true">Войти</a>
                <?php endif; ?>
                <?php if (isset($_SESSION['usr'])): ?>
                    <a href="settings.php" class="btn btn-link text-info" role="button" aria-pressed="true">Настройки</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php if (is_admin()): ?>
    <div class="container">
        <div class="row">
            <h2 class="mb-4">Товары</h2>
        </div>
        <div class="row mb-5">
            <a href="prod.php?action=add" class="btn btn-lg btn-info" role="button" aria-pressed="true">Добавить товар</a>
        </div>
        <div class="row mb-5">
            <h2 class="mb-4">Категории</h2>
            <table class="table">
                <tbody>
                <?php if (isset($_MAIN['cat'])): ?>
                    <?php foreach ($_MAIN['cat'] as $key => $value): ?>
                        <tr>
                            <th scope="row"><?=$key?></th>
                            <th scope="row"><?=$value?></th>
                            <td><a href="cat.php?action=rem&cat_id=<?=$key?>" class="btn btn-link text-danger" role="button" aria-pressed="true">Удалить</a></td>
                            <td><a href="cat.php?action=edit&cat_id=<?=$key?>" class="btn btn-link text-info" role="button" aria-pressed="true">Редакрировать</a></td>
                        </tr>
                    <?php endforeach ?>
                <?php endif ?>
                </tbody>
            </table>
            <a href="cat.php" class="btn btn-lg btn-info" role="button" aria-pressed="true">Добавить категорию</a>
        </div>
        <div class="row mb-5">
            <h2 class="mb-4">Пользователи</h2>
            <table class="table">
                <tbody>
                <?php if (isset($_MAIN['usr'])): ?>
                    <?php foreach ($_MAIN['usr'] as $key => $value): ?>
                        <?php if ($value['id'] != $_SESSION['usr']['id']): ?>
                            <tr>
                                <th scope="row"><?=$key?></th>
                                <th scope="row"><?=$value['login']?></th>
                                <?php if ($value['admin'] == true): ?>
                                    <th scope="row">админ</th>
                                <?php else: ?>
                                    <th scope="row">-</th>
                                <?php endif; ?>
                                <td><a href="settings.php?action=rem_usr&usr_id=<?=$key?>" class="btn btn-link text-danger" role="button" aria-pressed="true">Удалить</a></td>
                            </tr>
                        <?php endif ?>
                    <?php endforeach ?>
                <?php endif ?>
                </tbody>
            </table>
            <a href="settings.php?action=rem_usr&usr_id=me" class="btn btn-lg btn-info" role="button" aria-pressed="true">Удалить себя</a>
        </div>
        <div class="row mb-5">
            <h2 class="mb-4">Заказы</h2>
            <table class="table">
                <tbody>
                <?php if (isset($_MAIN['confirm'])): ?>
                    <?php foreach ($_MAIN['confirm'] as $key => $value): ?>
                        <tr>
                            <th scope="row"><?=$value['usr']['login']?></th>
                            <?php foreach ($value['bag'] as $key => $value): ?>
                                <th scope="row"><?=$_MAIN['prod'][$value]['name']?></th>
                            <?php endforeach ?>
                        </tr>
                    <?php endforeach ?>
                <?php endif ?>
                </tbody>
            </table>
        </div>
    </div>
<?php else: ?>
    <div class="container">
        <div class="row">
            <a href="settings.php?action=rem_usr&usr_id=me" class="btn btn-lg btn-info" role="button" aria-pressed="true">Удалить себя</a>
        </div>
    </div>
<?php endif ?>
</body>
</html>
