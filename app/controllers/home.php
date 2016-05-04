<?php

namespace Quiz\controllers;

use Quiz\models\QuestionModel as QuestionModel;

class Home
{

    private $page_title = "home";
    private $json_scripts = array("general_js.js", "admin_js.js");

    function __construct()
    {
        //TEST PENTRU A CONVERTI ARRAY IN CLASS SI SERIALIZE
//        $question_model = new QuestionModel ();
//        $question_model->convertArraytoClass();
        include VIEW_PATH . "head_view.php";
        include VIEW_PATH . "main_menu_view.php";
        include VIEW_PATH . "home_view.php";
        include VIEW_PATH . "footer_view.php";
    }

}
