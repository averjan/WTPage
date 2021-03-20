<?php

class controller_signup extends Controller
{
    function action_index()
    {
        $this->view->generate("/signup/signup.php");
    }

    function action_registration()
    {
        $mail = $_POST["email"];
        $reg = "/^[0-9a-zA-Z]+(\.[0-9a-zA-Z]+)*@([a-z0-9]([a-z0-9-]*[a-z0-9])?\.)+[a-z0-9]([a-z0-9-]*[a-z0-9])?$/";
        if (preg_match($reg, $mail))
        {
            $work_file = fopen(root."\src\mail.txt", "a+");
            fwrite($work_file, $_POST["username"] . " " . $mail . "\n");
            fclose($work_file);
            $this->view->generate("/home/home.php");
        }
        else
        {
            $this->view->generate("/signup/signup.php");
        }
    }
}