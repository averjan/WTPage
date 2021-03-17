<?php
    class View
    {
        function generate($template_view, $data = null)
        {
            // define("root", $_SERVER['DOCUMENT_ROOT']);
            include root . 'private/views' . $template_view;
        }
    }
