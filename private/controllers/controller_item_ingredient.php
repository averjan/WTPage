<?php

include root . '\private\models\item-ingredient\model_item_ingredient.php';
include root . '\private\models\home\model_home.php';

class controller_item_ingredient extends Controller
{
    public int $id;
    private model_home $home_model;

    function __construct()
    {
        $this->id = 0;
        $this->model = new model_item_ingredient();
        $this->view = new View();

        $this->home_model = new model_home();
    }

    function action_index()
    {
        if (isset($_GET['id'])) {
            $this->id = $_GET['id'];
            $l = $this->model->get_data();
            $data = [];
            foreach ($l as $el) {
                if ($this->id == $el['ID']) {
                    $data = $el;
                    break;
                }
            }

            $this->view->generate("/item_ingredient/item_ingredient.php", $data);
        }
    }

    function action_ingredient()
    {
        $routes = explode('/', $_SERVER['REQUEST_URI']);
        $this->id = intval($routes[3]);
        $l = $this->model->get_data();
        $this->id = array_search($this->id, array_column($l, 'ID'));
        $data = $l[$this->id];
        $this->view->generate("/item_ingredient/item_ingredient.php", $data);

    }

    function action_delete()
    {
        $routes = explode('/', $_SERVER['REQUEST_URI']);
        $this->id = intval($routes[3]);
        if ($this->check_authorised()) {
            $this->model->delete($this->id);
            header('Location: /ingredients');
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

/*
if (isset($_POST['id']))
{
    $id = $_POST['id'];
    $contr = new controller_item_ingredient();
    $contr->id = $id;
    $contr->action_index();
}
*/