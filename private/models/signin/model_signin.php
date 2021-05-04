<?php


class model_signin extends Model
{
    private function generateCode($length=6) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHI JKLMNOPRQSTUVWXYZ0123456789";
        $code = "";
        $clen = strlen($chars) - 1;
        while (strlen($code) < $length) {
            $code .= $chars[mt_rand(0,$clen)];
        }
        return $code;
    }

    public function check_user($login, $password): ?bool
    {
        $dbo = new PDO('mysql:dbname=elgusto_main;host=averkin.tim',
            'test_user',
            '',
            array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

        $sth = $dbo->prepare("SELECT * FROM users WHERE login LIKE :login");
        $sth->execute(array('login' => $login));
        $user = $sth->fetch(PDO::FETCH_ASSOC);

        if($user['password'] === md5(md5($password)))
        {
            // Генерируем случайное число и шифруем его
            $hash = md5($this->generateCode(10));


            $insip = $_SERVER['REMOTE_ADDR'];


            $sth = $dbo->prepare("UPDATE `users` SET `hash` = :hash, `ip` = INET_ATON(:ip) WHERE `id` = :id");
            $sth->execute(array('hash' => $hash, 'ip' => $insip, 'id' => $user['id']));

            // Ставим куки
            setcookie("id", $user['id'], time()+60*60*24*30, "/");
            setcookie("hash", $hash, time()+60*60*24*30, "/", null, null, true); // httponly !!!

            // Переадресовываем браузер на страницу проверки нашего скрипта
            //header("Location: check.php"); exit();
            return true;
        }
        else
        {
            print "Вы ввели неправильный логин/пароль";
            return false;
        }
    }
}