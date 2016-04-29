<?php

namespace Quiz\controllers;

use Quiz\models\RequestMethods as RequestMethods;
use Quiz\models\RenderModel as RenderModel;
use Quiz\models\RegistrationModel as RegistrationModel;
use Quiz\Entitiy\UserRepository as UserRepository;
use Quiz\models\AuthentificateModel as AuthentificateModel;

class Registration
{

    private $page_title = "registration";
    private $json_scripts = array("js_general.js");

    function __construct()
    {
        $user_repository = new UserRepository();
        $registration = new RegistrationModel ();
        $autentificate = new AuthentificateModel ();
        if (RequestMethods::post("user_type")) {
            $registration->registrate();
        }

        $data = $registration->getRenderData();
        $user = $registration->getUserData();
        if ($data['error'] == 0) {
            $rights = $user_repository->file_permission;
            if ($user_repository->insertUser($user)&&$rights=="0777") { //NOT A GOOD VALIDATION
                $autentificate->login();
                $autentificate->startSession();
            } else {
                echo "File permission needed to register user";
            }
        }

        include VIEW_PATH . "head_view.php";
        include VIEW_PATH . "main_menu_view.php";
        $registration->render(VIEW_PATH . "user_register_form_view.php", $data);
        include VIEW_PATH . "footer_view.php";
    }

}
