<?php
//define("root", $_SERVER['DOCUMENT_ROOT']);
include root . '\private\models\item-ingredient\model_item_ingredient.php';
class controller_ingredients extends Controller
{
    function __construct()
    {
        $this->model = new model_item_ingredient();
        $this->view = new View();
    }

    function action_index()
    {
        $data = $this->model->get_data();
        $this->view->generate("/ingredients/ingredients.php", $data);
    }
}