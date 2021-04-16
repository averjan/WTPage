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

    function action_filter()
    {
        $base = 0;
        $data = $this->model->get_data_filtered(array(
            "Item" => empty($_GET['search']) ? '%' : '%'.$_GET['search'].'%',
            "Base" => empty($_GET['base']) ? '%' : $_GET['base'],
            "Strong" => empty($_GET['strong']) ? '%' : $_GET['strong'],
            "Taste" => empty($_GET['taste']) ? '%' : $_GET['taste']
            ));

        $html = $this->create_html($data);
        echo json_encode($html);
    }

    function create_html($data)
    {
        $l = '';
        for ($i = 0; $i < count($data); $i++)
        {
            $l = $l .
                '<form method="get" action="/item_cocktail/cocktail/'.$data[$i]["ID"].'" class="cocktail-item">
                <a type="submit" onclick="this.closest(\'form\').submit()" class="cocktail-item-preview">
                    <img src="../../img/cocktails/'.$data[$i]["FileName"] . '.jpg" alt="'.$data[$i]["FileName"].'" class="cocktail-item-image"/>
                    <div class="cocktail-item-name">'.$data[$i]["Name"].'</div>
                </a>
                <input type="hidden" name="id" value="'.$i.'">
                </form>';
        }

        return $l;
    }
}