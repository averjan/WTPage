<?php
/*
    $main_template = file_get_contents("index.html");

    $main_template = str_replace("{header}",
        file_get_contents("common/header.html"),
        $main_template);

    $main_template = str_replace("{footer}",
    file_get_contents("common/footer.html"),
    $main_template);

    $main_template = str_replace("{navbar}",
    file_get_contents("common/navbar.html"),
    $main_template);

    $main_template = str_replace("{description}",
    file_get_contents("modules/main_page/view/main_page.html"),
    $main_template);

    echo $main_template;
*/
define("root", $_SERVER['DOCUMENT_ROOT']);
require_once "boot.php";
