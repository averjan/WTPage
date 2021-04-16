<?php

include root . '\private\models\search\model_search.php';
class controller_search extends Controller
{
    function __construct()
    {
        $this->model = new model_search();
        $this->view = new View();
    }

    function action_index()
    {
        $data = $this->model->get_data_filtered('%'.$_GET["search"].'%');
        $this->view->generate("/search/search.php", $data);
    }
}