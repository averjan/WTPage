<?php


class controller_main extends controller
{
    function action_index()
    {
        $this->view->generate("\main_page\main_page.php");
    }
}