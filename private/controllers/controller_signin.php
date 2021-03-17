<?php


class controller_signin extends controller
{
    function action_index()
    {
        $this->view->generate("\signin\signin.php");
    }
}