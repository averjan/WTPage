<?php

include root . '\private\models\item-cocktail\model_item_cocktail.php';
include root . '\private\controllers\controller_item_ingredient.php';
class controller_cocktails extends Controller
{
    function __construct()
    {
        $this->model = new model_item_cocktail();
        $this->view = new View();
    }

    function action_index()
    {

        $data = $this->model->get_data();
        $this->view->generate("/cocktails/cocktails.php", $data);
    }
}