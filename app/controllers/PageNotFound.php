<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Quiz\controllers;

/**
 * Description of PageNotFound
 *
 * @author bogdanhaidu
 */
class PageNotFound
{

    private $page_title = "error";
    private $json_scripts = array();

    function __construct()
    {
        include VIEW_PATH . "head_view.php";
        include VIEW_PATH . "page_not_found_view.php";
        include VIEW_PATH . "footer_view.php";
    }
}
