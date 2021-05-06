<?php


include root . '\private\models\item-cocktail\model_item_cocktail.php';
include root . '\private\models\home\model_home.php';
include root . '\private\models\item-ingredient\model_item_ingredient.php';

class controller_edit_cocktail extends Controller
{
    private model_home $home_model;
    private model_item_ingredient $ingredient_model;
    private int $id;

    function __construct()
    {
        $this->model = new model_item_cocktail();
        $this->view = new View();

        $this->home_model = new model_home();
        $this->ingredient_model = new model_item_ingredient();
    }

    function action_index()
    {
        if ($this->check_authorised()) {
            $data['to'] = $this->ingredient_model->get_data();

            $routes = explode('/', $_SERVER['REQUEST_URI']);
            $this->id = intval($routes[3]);
            $l = $this->model->get_data();
            //$data = $l[$this->id];
            foreach ($l as $el) {
                if ($this->id == $el['ID']) {
                    $data['is'] = $el;
                    break;
                }
            }

            foreach ($data['is']['Recipe'] as $item) {
                //$data['to'] = array_diff($data['to'], $data['is']['Recipe']);
                //$key = array_search($item['ingredient'], $data['to'], false);
                //print_r($data['to']);
                $i = 0;
                foreach ($data['to'] as $el) {
                    if ($item['ingredient']['ID'] == $el['ID']) {
                        unset($data['to'][$i]);
                    }
                }
            }

            $this->view->generate("/edit_cocktail/edit_cocktail.php", $data);
        }
        else {
            //header("HTTP/1.1 401 Unauthorized"); exit;
            header("Location: /signin"); exit;
        }
    }

    function action_save()
    {
        if ($this->check_authorised()) {
            //print_r(json_decode($_POST['list']));
            $this->model->save($_POST);
            header("Location: /item_cocktail/cocktail/".strval($_POST['ID'])); exit;
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