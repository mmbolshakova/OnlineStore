<?php
session_start();
require_once('./private/main.php');
require_once('./private/lib.php');

$_MAIN['prod'] = get_file('./data/prod');
$_MAIN['cat'] = get_file('./data/cat');
$countprice = 0;
if (isset($_GET['add']))
{
    header('Location: index.php?msg_ok=добавленно');
    if (!isset($_SESSION['bag']))
        $_SESSION['bag'] = [];
    $_SESSION['bag'][] = $_GET['add'];
}
else if (isset($_GET['remove']))
{
    if (isset($_SESSION['bag'][$_GET['remove']]))
        unset($_SESSION['bag'][$_GET['remove']]);
}
else if (isset($_GET['confirm']))
{
    $_MAIN['confirm'] = get_file('./data/confirm');
    if ($_SESSION['bag'])
    {
        if ($_SESSION['usr'])
        {
            $_MAIN['confirm'][] = [
                'usr' => $_SESSION['usr'],
                'bag' => $_SESSION['bag']
            ];
            update_file('./data/confirm', $_MAIN['confirm']);
            unset($_SESSION['bag']);
            $_MAIN['msg_ok'] = 'Заказ подтвержден';
        }
        else
            $_MAIN['msg_err'] = 'Для подтверждения заказа необходимо зайти в свою учетную запись';
    }
    else
        $_MAIN['msg_err'] = 'Корзина пуста';
}
if ($_SESSION['bag'])
    foreach ($_SESSION['bag'] as $key => $value)
        $countprice = $countprice + $_MAIN['prod'][$value]['price'];
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
<div class="container">
    <div class="row">
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
    </div>
    <div class="row">
        <table class="table">
            <thead>
            <tr>
                <th scope="col">Товар</th>
                <th scope="col">Описание</th>
                <th scope="col">Цена</th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            <?php if (isset($_SESSION['bag'])): ?>
                <?php foreach ($_SESSION['bag'] as $key => $value): ?>
                    <?php if (isset($_MAIN['prod'][$value])): ?>
                        <tr>
                            <th scope="row"><?=$_MAIN['prod'][$value]['name']?></th>
                            <th scope="row"><?=$_MAIN['prod'][$value]['description']?></th>
                            <td><?=$_MAIN['prod'][$value]['price']?></td>
                            <td><a href="bag.php?remove=<?=$key?>" class="btn btn-link text-danger" role="button" aria-pressed="true">удалить</a></td>
                        </tr>
                    <?php endif ?>
                <?php endforeach ?>
            <?php endif ?>
            </tbody>
        </table>
    </div>
    <div class="row"><h3>Общая стоимость: <?=$countprice?><?=$_MAIN['currency']?></h3></div>
    <?php if (count($_SESSION['bag']) > 0): ?>
        <div class="row"><a href="bag.php?confirm" class="btn btn-outline-info mt-4" role="button" aria-pressed="true">Подтвердить заказ</a></div>
    <?php endif ?>
</body>
</html>
