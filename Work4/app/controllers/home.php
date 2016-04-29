<?php

namespace Quiz\controllers;


class Home
{

    private $page_title = "home";
    private $json_scripts = array("js_general.js", "admin_js.js");

    function __construct()
    {
        include VIEW_PATH . "head_view.php";
        include VIEW_PATH . "main_menu_view.php";
        include VIEW_PATH . "home_view.php";
        include VIEW_PATH . "footer_view.php";
    }

}
