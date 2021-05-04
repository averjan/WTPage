<?php

include root . '\private\models\item-cocktail\model_item_cocktail.php';
include root . '\private\models\home\model_home.php';

class controller_add_item extends controller
{
    private model_home $home_model;

    function __construct()
    {
        $this->model = new model_item_cocktail();
        $this->view = new View();

        $this->home_model = new model_home();
    }

    function action_index()
    {
        if ($this->check_authorised()) {
            $this->view->generate("/add_item/add_item.php");
        }
        else {
            header("HTTP/1.1 401 Unauthorized"); exit;
        }
    }

    function action_create()
    {
        if ($this->check_authorised()) {
            $this->model->push($_POST);
            header("Location: /cocktails"); exit;
        }
        else {
            header("HTTP/1.1 401 Unauthorized"); exit;
        }
    }

    private function check_authorised()
    {
        if (isset($_COOKIE['id']) and isset($_COOKIE['hash'])
            and $this->home_model->is_right_cookie(array(
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