<?php

include root . '\private\models\item-cocktail\model_item_cocktail.php';
include root . '\private\models\home\model_home.php';
include root . '\private\models\item-ingredient\model_item_ingredient.php';

class controller_edit_ingredient extends Controller
{
    private model_home $home_model;
    private model_item_cocktail $cocktail_model;
    private int $id;

    function __construct()
    {
        $this->model = new model_item_ingredient();
        $this->view = new View();

        $this->home_model = new model_home();
        $this->cocktail_model = new model_item_cocktail();
    }

    function action_index()
    {
        if ($this->check_authorised()) {
            $data = $this->cocktail_model->get_data();

            $routes = explode('/', $_SERVER['REQUEST_URI']);
            $this->id = intval($routes[3]);
            $l = $this->model->get_data();
            foreach ($l as $el) {
                if ($this->id == $el['ID']) {
                    $data = $el;
                    break;
                }
            }

            $this->view->generate("/edit_ingredient/edit_ingredient.php", $data);
        }
        else {
            header("HTTP/1.1 401 Unauthorized"); exit;
        }
    }

    function action_save()
    {
        if ($this->check_authorised()) {
            $this->model->save($_POST);
            header("Location: /item_ingredient/ingredient/".strval($_POST['ID'])); exit;
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