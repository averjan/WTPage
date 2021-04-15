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

    function action_filter()
    {
        $data = $this->model->get_data_filtered(array(
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
                '<form method="get" action="/item_ingredient/ingredient/'.$data[$i]["ID"].'" class="cocktail-item">
                <a type="submit" onclick="this.closest(\'form\').submit()" class="cocktail-item-preview">
                    <img src="../../img/ingredients/'.$data[$i]["FileName"] . '.png" alt="'.$data[$i]["FileName"].'" class="cocktail-item-image"/>
                    <div class="cocktail-item-name">'.$data[$i]["Name"].'</div>
                </a>
                <input type="hidden" name="id" value="'.$data[$i]["ID"].'">
     </form>';
        }

        return $l;
    }
}