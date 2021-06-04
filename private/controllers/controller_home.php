<?php

include root . '\private\models\home\model_home.php';

class controller_home extends controller
{
    function __construct()
    {
        $this->model = new model_home();
        $this->view = new View();
    }

    function action_index()
    {
        if ($this->check_authorised()) {
            $this->view->generate("\home\home.php");
        }
        else {
            //$this->view->generate("\home\home.php");
            header("HTTP/1.1 401 Unauthorized"); exit;
        }
    }

    function action_logout()
    {
        // Удаляем куки
        setcookie("id", "", time() - 3600*24*30*12, "/");
        setcookie("hash", "", time() - 3600*24*30*12, "/",null,null,true); // httponly !!!

        header("Location: /"); exit;
    }

    private function check_authorised()
    {
        if (isset($_COOKIE['id']) and isset($_COOKIE['hash'])
            and $this->model->is_right_cookie(array(
                'id'=>$_COOKIE['id'],
                'hash' => $_COOKIE['hash'],
                'addr' => $_SERVER['REMOTE_ADDR']))) {


            return true;
        }
        else {
            return false;
        }
    }
}