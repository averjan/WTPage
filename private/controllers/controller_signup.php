<?php

class controller_signup extends Controller
{
    public string $mail_error = "";

    function action_index()
    {
        $this->view->generate("/signup/signup.php");
    }

    function action_registration()
    {
        $mail = $_POST["email"];
        // $reg = "/^[0-9a-zA-Z]+(\.[0-9a-zA-Z]+)*@([a-z0-9]([a-z0-9-]*[a-z0-9])?\.)+[a-z0-9]([a-z0-9-]*[a-z0-9])?$/";
        // $reg = "/^(?:[\s]*)([\d\w]+(?:\.[\d\w]+)*@(?:[a-z\d](?:[a-z\d-]*[a-z\d])?\.)+[a-z\d](?:[a-z\d-]*[a-z\d])?)(?:[\s]*)$/";
        $reg = "/^(?:\s*)([\d\w!#$%&'*+\/=?^_`{|}~-]+(?:\.[\d\w!#$%&'*+\/=?^_`{|}~-]+)*@(?:[a-z\d](?:[a-z\d-]*[a-z\d])?\.)+[a-z\d](?:[a-z\d-]*[a-z\d])?)(?:\s*)$/";
        if (preg_match($reg, $mail, $match))
        {
            $work_file = fopen(root."\src\mail.txt", "a+");
            fwrite($work_file, $_POST["username"] . " " . $match[1] . "\n");
            fclose($work_file);
            $this->view->generate("/home/home.php");
        }
        else
        {
            $mail_error = "Incorrect email";
            $this->view->generate("/signup/signup.php", $mail_error);
        }
    }
}