<?php

include root . '\private\models\item-cocktail\model_item_cocktail.php';
include root . '\private\models\home\model_home.php';

class controller_item_cocktail extends Controller
{
    public int $id;
    private model_home $home_model;

    function __construct()
    {
        $this->id = 0;
        $this->model = new model_item_cocktail();
        $this->view = new View();

        $this->home_model = new model_home();
    }

    function action_index()
    {
        if (isset($_GET['id'])) {
            $this->id = $_POST['id'];
            $l = $this->model->get_data();
            $data = $l[$this->id];
            $this->view->generate("/item_cocktail/item_cocktail.php", $data);
        }
    }

    function action_cocktail()
    {
        $routes = explode('/', $_SERVER['REQUEST_URI']);
        $this->id = intval($routes[3]);
        $l = $this->model->get_data();
        //$data = $l[$this->id];
        foreach ($l as $el) {
            if ($this->id == $el['ID']) {
                $data = $el;
                break;
            }
        }

        $this->view->generate("/item_cocktail/item_cocktail.php", $data);
    }

    function action_delete()
    {
        if ($this->check_authorised()) {
            $this->model->delete($_GET['id']);
            header('Location: /cocktails');
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