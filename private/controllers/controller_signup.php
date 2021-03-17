<?php

class controller_signup extends Controller
{
    function action_index()
    {
        $this->view->generate("/signup/signup.php");
    }
}