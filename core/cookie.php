<?php
function is_right_cookie($cookie): bool
{
    $dbo = new PDO('mysql:dbname=elgusto_main;host=averkin.tim',
        'test_user',
        '',
        array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

    $sth = $dbo->prepare("SELECT *, INET_NTOA(ip) AS ip FROM users WHERE id = :id");
    $sth->execute(array('id' => intval($cookie['id'])));
    $user = $sth->fetch(PDO::FETCH_ASSOC);
    if(($user['hash'] !== $cookie['hash']) or ($user['id'] !== $cookie['id'])
        or (($user['ip'] !== $cookie['addr'])  and ($user['ip'] !== "0")))
    {
        setcookie("id", "", time() - 3600*24*30*12, "/");
        setcookie("hash", "", time() - 3600*24*30*12, "/", null, null, true);
        return false;
    }
    else
    {
        return true;
    }

}

function check_authorised(): bool
{
    if (isset($_COOKIE['id']) and isset($_COOKIE['hash'])
        and is_right_cookie(array(
            'id'=>$_COOKIE['id'],
            'hash' => $_COOKIE['hash'],
            'addr' => $_SERVER['REMOTE_ADDR']))) {


        return true;
    }
    else {
        return false;
    }
}

function construct_header(): string
{
    if (check_authorised())
    {
        return file_get_contents(root . "common/navbar-authorized.html");
    }

    return file_get_contents(root . "/common/navbar.html");
}