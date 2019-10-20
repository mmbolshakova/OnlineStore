<?php
session_start();
require_once('./private/main.php');
require_once('./private/lib.php');

$_prod = [
    'img_url' => $_POST['img_url'],
    'name' => $_POST['name'],
    'description' => $_POST['description'],
    'cat' => $_POST['cat'],
    'price' => (int)$_POST['price']
];

$_MAIN['cat'] = get_file('./data/cat');
$_MAIN['prod'] = get_file('./data/prod');
if (isset($_POST['img_url']) && isset($_POST['name']) && isset($_POST['description']) &&
    isset($_POST['price']) && isset($_POST['action']) && $_POST['action'] == 'add')
{
    $_MAIN['prod'][] = $_prod;
    update_file('./data/prod', $_MAIN['prod']);
    header('Location: index.php?msg_ok=добавленно');
}

else if (is_admin() && isset($_POST['img_url']) && isset($_POST['name']) && isset($_POST['description']) &&
    isset($_POST['price']) && isset($_POST['prod_id']) && isset($_POST['action']) && $_POST['action'] == 'edit')
{
    if (isset($_MAIN['prod'][$_POST['prod_id']]))
    {
        $_MAIN['prod'][$_POST['prod_id']] = $_prod;
        update_file('./data/prod', $_MAIN['prod']);
        header('Location: index.php?msg_ok=изменено');
    }
    else
        $_MAIN['msg_err'] = 'Ошибка';
}

else if (is_admin() && isset($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['prod_id'])) {
    if (isset($_MAIN['prod'][$_GET['prod_id']]))
        $_prod = $_MAIN['prod'][$_GET['prod_id']];
    else
        $_MAIN['msg_err'] = 'Ошибка';
}

elseif (is_admin() && isset($_GET['action']) && $_GET['action'] == 'rem' && isset($_GET['prod_id'])) {
    if (isset($_MAIN['prod'][$_GET['prod_id']]))
    {
        unset($_MAIN['prod'][$_GET['prod_id']]);
        update_file('./data/prod', $_MAIN['prod']);
        header('Location: index.php?msg_ok=удаленно');
    }
    else
        header('Location: index.php?msg_err=ошибка');
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
    <form method="post" action="prod.php" class="m-auto" style="max-width: 800px">
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
        <div class="form-group">
            <label for="img_url">Img URL</label>
            <input type="text" class="form-control" id="img_url" value="<?=$_prod['img_url']?>" name="img_url">
        </div>
        <div class="form-group">
            <label for="name">Название</label>
            <input type="text" class="form-control" id="name" value="<?=$_prod['name']?>" name="name">
        </div>
        <div class="form-group">
            <label for="description">Описание</label>
            <input type="text" class="form-control" id="description" value="<?=$_prod['description']?>" name="description">
        </div>
        <div class="form-group">
            <label for="cat">Категория</label>
            <select class="form-control" id="cat" name="cat">
                <?php foreach ($_MAIN['cat'] as $key => $value): ?>
                <option value="<?=$key?>"><?=$value?></option>
                <?php endforeach ?>
            </select>
        </div>
        <div class="form-group">
            <label for="price">Цена</label>
            <input type="number" class="form-control" id="price" value="<?=$_prod['price']?>" name="price">
        </div>
        <?php if (is_admin() && isset($_GET['action']) && $_GET['action'] == 'edit'): ?>
            <input type="hidden" name="action" value="edit">
            <input type="hidden" name="prod_id" value="<?=$_GET['prod_id']?>">
            <button type="submit" class="btn btn-outline-info">Изменить</button>
        <?php else: ?>
            <input type="hidden" name="action" value="add">
            <button type="submit" class="btn btn-outline-info">Сохранить</button>
        <?php endif ?>
        <a href="settings.php" class="btn btn-outline-info ml-3" role="button" aria-pressed="true">В настройки</a>

    </form>
</div>
</body>
</html>
