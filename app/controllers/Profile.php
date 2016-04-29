<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Quiz\controllers;
use Quiz\Entitiy\UserRepository as UserRepository;
/**
 * Description of Profile
 *
 * @author bogdanhaidu
 */
class Profile
{
    private $page_title = "profile";
    private $json_scripts = array("js_general.js", "admin_js.js");

    function __construct()
    {
        include VIEW_PATH . "head_view.php";
        include VIEW_PATH . "main_menu_view.php";
        $user_repository = new UserRepository();
        var_dump($_SESSION);
        $result = $user_repository->getEmailById($_SESSION['user']['id']);
        //$result = $user_repository->getUserByUsername("haidu_bogdan@yahoo.com");
        var_dump($result);
        //include VIEW_PATH . "home_view.php";
        include VIEW_PATH . "footer_view.php";
    }
}
