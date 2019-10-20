<?php
session_start();
require_once('./private/main.php');
require_once('./private/lib.php');

$_MAIN['cat'] = get_file('./data/cat');
$only_catygory = false;
$_MAIN['prod'] = get_file('./data/prod');
if (isset($_GET['catygory']))
    $only_catygory = $_GET['catygory'];
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
        <?php foreach ($_MAIN['prod'] as $key => $value): ?>
            <?php if ($only_catygory === false || $value['cat'] === $only_catygory): ?>
            <div class="col mb-4">
                <div class="card" style="min-width: 250px">
                    <img src="<?=$value['img_url']?>" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title"><?=$value['name']?></h5>
                        <p class="card-text"><?=$value['description']?></p>
                        <p class=""><?=$_MAIN['cat'][$value['cat']]?></p>
                        <p class="text-info h3 mb-3"><?=$value['price']?> p.</p>

                        <?php if (is_admin()): ?>
                            <a href="prod.php?action=edit&prod_id=<?=$key?>" class="btn btn-info">Редактировать</a>
                            <a href="prod.php?action=rem&prod_id=<?=$key?>" class="btn btn-danger">Удалить</a>
                        <?php else: ?>
                            <a href="bag.php?add=<?=$key?>" class="btn btn-info">В корзину</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endif ?>
        <?php endforeach ?>
    </div>
</div>
</body>
</html>
