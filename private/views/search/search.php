<?php
//define("root", $_SERVER['DOCUMENT_ROOT']);

$main_template = file_get_contents(root . "/index.html");

$main_template = str_replace("{header}",
    file_get_contents(root . "/common/header.html"),
    $main_template);

$main_template = str_replace("{footer}",
    file_get_contents(root . "/common/footer.html"),
    $main_template);

$main_template = str_replace("{navbar}",
    file_get_contents(root . "/common/navbar.html"),
    $main_template);

$main_template = str_replace("{description}",
    file_get_contents(root . 'private\views\search\search.html'),
    $main_template);
$array_data = $data["ingredients"];
$l = "";

for ($i = 0; $i < count($data["ingredients"]); $i++)
{
    $l = $l .
        '<form method="get" action="/item_ingredient/ingredient/'.$array_data[$i]["ID"].'" class="cocktail-item">
                <a type="submit" onclick="this.closest(\'form\').submit()" class="cocktail-item-preview">
                    <img src="../../../img/ingredients/'.$array_data[$i]["FileName"] . '.png" alt="'.$array_data[$i]["FileName"].'" class="cocktail-item-image"/>
                    <div class="cocktail-item-name">'.$array_data[$i]["Name"].'</div>
                </a>
                <input type="hidden" name="id" value="'.$array_data[$i]["ID"].'">
     </form>';
}

$array_data = $data["cocktails"];
$l1 = "";
for ($i = 0; $i < count($data["cocktails"]); $i++)
{
    $l1 = $l1 .
        '<form method="get" action="/item_cocktail/cocktail/'.$array_data[$i]["ID"].'" class="cocktail-item">
                <a type="submit" onclick="this.closest(\'form\').submit()" class="cocktail-item-preview">
                    <img src="../../../img/cocktails/'.$array_data[$i]["FileName"] . '.jpg" alt="'.$array_data[$i]["FileName"].'" class="cocktail-item-image"/>
                    <div class="cocktail-item-name">'.$array_data[$i]["Name"].'</div>
                </a>
                <input type="hidden" name="id" value="'.$array_data[$i]["ID"].'">
     </form>';
}

$main_template = str_replace("{ingredient-items}",
    $l,
    $main_template);

$main_template = str_replace("{cocktail-items}",
    $l1,
    $main_template);

eval('?>'.$main_template);
