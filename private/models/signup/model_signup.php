<?php


class model_signup extends Model
{
    public function get_data(): ?array
    {

    }

    public function add_user(string $email, string $login, string $password)
    {
        $dbo = new PDO('mysql:dbname=elgusto_main;host=averkin.tim',
            'test_user',
            '',
            array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

        $err = [];

        // проверям логин
        if(!preg_match("/^[a-zA-Z0-9]+$/",$login))
        {
            $err[] = "Логин может состоять только из букв английского алфавита и цифр";
        }

        if(strlen($login) < 3 or strlen($login) > 30)
        {
            $err[] = "Логин должен быть не меньше 3-х символов и не больше 30";
        }

        $user_array = array();
        $sth = $dbo->prepare("SELECT * FROM users WHERE login LIKE :login");
        $sth->execute(array('login' => $login));
        while ($required_array = $sth->fetch(PDO::FETCH_ASSOC)) {
            array_push($user_array, $required_array);
        }

        if (count($user_array) > 0)
        {
            $err[] = "Пользователь с таким логином уже существует в базе данных";
        }

        if(count($err) == 0)
        {

            // password_hash($password,  PASSWORD_BCRYPT)
            $password = md5(md5(trim($password)));

            $sth = $dbo->prepare("INSERT INTO `users` SET `login` = :login, `password` = :password, `email` = :email");
            $sth->execute(array('login' => $login, 'password' => $password, 'email' => $email));
        }
        else
        {
            /*
            print "<b>При регистрации произошли следующие ошибки:</b><br>";
            foreach($err AS $error)
            {
                print $error."<br>";
            }
            */
            return false;
        }

        return true;
    }
}