<?php
session_start();
require_once('./private/main.php');
require_once('./private/lib.php');

$_MAIN['cat'] = get_file('./data/cat');
$cat_name = false;

echo $cat_name;
if (isset($_POST['action']) && $_POST['action'] == 'add' && isset($_POST['cat_name']))
{
    if (array_search($_POST['cat_name'], $_MAIN['cat']) == false)
    {
        $_MAIN['cat'][] = $_POST['cat_name'];
        update_file('./data/cat', $_MAIN['cat']);
        $_MAIN['msg_ok'] = 'Категерия добавленна';
    }
    else
        $_MAIN['msg_err'] = 'Данная категория существует';
}

else if (is_admin() && isset($_POST['action']) && $_POST['action'] == 'edit' && isset($_POST['cat_id']) && isset($_POST['cat_name']))
{
    if (isset($_MAIN['cat'][$_POST['cat_id']]) && array_search($_POST['cat_name'], $_MAIN['cat']) == false)
    {
        $_MAIN['cat'][$_POST['cat_id']] = $_POST['cat_name'];
        update_file('./data/cat', $_MAIN['cat']);
        header('Location: settings.php?msg_ok=сохраненно');
    }
    else
        header('Location: settings.php?msg_err=ошибка');
}
else if (is_admin() && isset($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['cat_id']))
{
    if (isset($_MAIN['cat'][$_GET['cat_id']]))
        $cat_name = $_MAIN['cat'][$_GET['cat_id']];
    else
        header('Location: settings.php?msg_err=ошибка');
}
else if (is_admin() && isset($_GET['action']) && $_GET['action'] == 'rem' && isset($_GET['cat_id']))
{
    if (isset($_MAIN['cat'][$_GET['cat_id']]))
    {
        unset($_MAIN['cat'][$_GET['cat_id']]);
        update_file('./data/cat', $_MAIN['cat']);
        header('Location: settings.php?msg_ok=удаленно');
    }
    else
        header('Location: settings.php?msg_err=ошибка');
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
    <form method="post" action="cat.php" class="m-auto" style="max-width: 800px">
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
            <label for="cat_name">Название категории</label>
            <input type="text" class="form-control" id="cat_name" name="cat_name" value="<?=$cat_name?>">
        </div>
        <?php if (is_admin() && isset($_GET['cat_id']) && isset($_GET['action']) && $_GET['action'] == 'edit'): ?>
            <input type="hidden" name="action" value="edit">
            <input type="hidden" name="cat_id" value="<?=$_GET['cat_id']?>">
            <button type="submit" class="btn btn-outline-info mr-2">Изменить</button>
        <?php else: ?>
            <input type="hidden" name="action" value="add">
        <button type="submit" class="btn btn-outline-info">Сохранить</button>
        <?php endif; ?>
        <a href="settings.php" class="btn btn-outline-info ml-3" role="button" aria-pressed="true">В настройки</a>
    </form>
</div>
</body>
</html>
