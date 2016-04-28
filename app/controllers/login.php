<?php

namespace Quiz\controllers;

use Quiz\models\UserModel as UserModel;
use Quiz\models\AuthentificateModel as AuthentificateModel;
use Quiz\models\RequestMethods as RequestMethods;
use Quiz\models\RenderModel as RenderModel;

class Login
{

    private $page_title = "login";
    private $json_scripts = array("js_general.js");

    function __construct()
    {
        $autentificate = new AuthentificateModel ();
        if (RequestMethods::post("user_type")) {
            $autentificate->login();
        }
        $data = $autentificate->getRenderData();

        if (filter_input(INPUT_GET, 'logout')) {
            $autentificate->descructSession();
        }

        include VIEW_PATH . "head_view.php";
        include VIEW_PATH . "main_menu_view.php";
        if (!$data['error']) {
            echo "incepeme";
            $autentificate->startSession();
        } else {
            $autentificate->render(VIEW_PATH . "user_login_form_view.php", $data);
        } 
  
        include VIEW_PATH . "footer_view.php";
    }

    public function startLogin()
    {
        
    }

}
