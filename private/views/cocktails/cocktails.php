<?php
// define("root", $_SERVER['DOCUMENT_ROOT']);

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
    file_get_contents(root . '\private\views\cocktails\cocktails.html'),
    $main_template);

$l = "";
for ($i = 0; $i < count($data); $i++)
{
    $l = $l .
    '<form method="get" action="/item_cocktail/cocktail/'.$data[$i]["ID"].'" class="cocktail-item">
                <a type="submit" onclick="this.closest(\'form\').submit()" class="cocktail-item-preview">
                    <img src="../../../img/cocktails/'.$data[$i]["FileName"] . '.jpg" alt="'.$data[$i]["FileName"].'" class="cocktail-item-image"/>
                    <div class="cocktail-item-name">'.$data[$i]["Name"].'</div>
                </a>
                <input type="hidden" name="id" value="'.$data[$i]["ID"].'">
     </form>';
}

$main_template = str_replace("{items}",
    $l,
    $main_template);

$sub_navbar = file_get_contents(root . "/common/sub-navbar.html");
$main_template = str_replace("{sub_navbar}",
    $sub_navbar,
    $main_template);

echo $main_template;
