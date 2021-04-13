<?php

include root . '\private\models\item-cocktail\model_item_cocktail.php';
class controller_item_cocktail extends Controller
{
    public int $id;

    function __construct()
    {
        $this->id = 0;
        $this->model = new model_item_cocktail();
        $this->view = new View();
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
        $data = $l[$this->id];
        //$data = $l[0];
        $this->view->generate("/item_cocktail/item_cocktail.php", $data);
    }
}