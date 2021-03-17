<?php

include root . '\private\models\item-ingredient\model_item_ingredient.php';
class controller_item_ingredient extends Controller
{
    public int $id;

    function __construct()
    {
        $this->id = 0;
        $this->model = new model_item_ingredient();
        $this->view = new View();
    }

    function action_index()
    {
        if (isset($_POST['id'])) {
            $this->id = $_POST['id'];
            $l = $this->model->get_data();
            $data = $l[$this->id];
            $this->view->generate("/item_ingredient/item_ingredient.php", $data);
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