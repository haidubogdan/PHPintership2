<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Quiz\models;

/**
 * Description of RequestMethods
 *
 * @author bogdanhaidu
 */
class RequestMethods
{

    public static function get($key, $default = "")
    {
        if (!empty(filter_input(INPUT_GET, $key))) {
            return filter_input(INPUT_GET, $key);
        }
        return $default;
    }

    public static function post($key, $default = "")
    {
        if (!empty(filter_input(INPUT_POST, $key))) {
            return filter_input(INPUT_POST, $key);
        }
        return $default;
    }

}
