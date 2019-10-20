<?php

function get_file($paht)
{
    if (file_exists($paht))
        return unserialize(file_get_contents($paht));
    else
        return [];
}

function update_file($path, $data)
{
    file_put_contents($path, serialize($data));
}


function get_user($arr, $login, $pas)
{
    foreach ($arr as $key => $val)
    {
        if ($val['login'] === $login && $val['pass'] === $pas)
            return $val;
    }
    return false;
}

function is_admin()
{
    if (isset($_SESSION['usr']) && $_SESSION['usr']['admin'] == true)
        return true;
    return false;
}

