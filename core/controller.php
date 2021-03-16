<?php

use JetBrains\PhpStorm\Pure;

class Controller
    {
        public Model $model;
        public View $view;

        #[Pure] function __construct()
        {
            $this->view = new View();
        }

        function action_index()
        {
        }
    }
