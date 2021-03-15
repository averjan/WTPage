<?php
define("root", $_SERVER['DOCUMENT_ROOT']);

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
    file_get_contents("itemIngredient.html"),
    $main_template);

$main_template = str_replace("{sub-navbar}",
    file_get_contents(root . "/common/sub-navbar.html"),
    $main_template);

echo $main_template;
