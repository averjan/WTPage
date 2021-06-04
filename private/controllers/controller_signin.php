<?php


include root . '\private\models\signin\model_signin.php';

class controller_signin extends controller
{
    function __construct()
    {
        $this->model = new model_signin();
        $this->view = new View();
    }

    function action_index()
    {
        $this->view->generate("\signin\signin.php");
    }

    function action_signin()
    {
        if ($this->model->check_user($_POST["login"], $_POST["password"])) {
            //$this->view->generate("/home/home.php");
            header('Location: /home');
        }

        $this->view->generate("/signin/signin.php");
    }
}