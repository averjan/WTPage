<?php


class controller_main extends controller
{
    function action_index()
    {
        $this->view->generate("\main_page\main_page.php");
    }

    function action_logout()
    {
        // Удаляем куки
        setcookie("id", "", time() - 3600*24*30*12, "/");
        setcookie("hash", "", time() - 3600*24*30*12, "/",null,null,true); // httponly !!!

        header("Location: /"); exit;
    }
}