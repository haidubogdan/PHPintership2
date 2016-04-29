<?php

namespace Quiz\controllers;

use Quiz\models\RequestMethods as RequestMethods;
use Quiz\models\RenderModel as RenderModel;
use Quiz\models\RegistrationModel as RegistrationModel;

class Registration
{

    private $page_title = "registration";
    private $json_scripts = array("js_general.js");

    function __construct()
    {
        $registration = new RegistrationModel ();
        if (RequestMethods::post("user_type")) {
            $registration->registrate();
        }

        $data = $registration->getRenderData();
        if ($data['error'] == 0) {
            if ($registration->insertUser()) {
                $registration->startSession();
            }
        }

        include VIEW_PATH . "head_view.php";
        include VIEW_PATH . "main_menu_view.php";
        $registration->render(VIEW_PATH . "user_register_form_view.php", $data);
        include VIEW_PATH . "footer_view.php";
    }

}
