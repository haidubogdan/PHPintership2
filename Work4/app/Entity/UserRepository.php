<?php

namespace Quiz\Entitiy;

use Quiz\models\DB as DB;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UserRepository
 *
 * @author bogdanhaidu
 */
class UserRepository extends DB
{

    private $save_path = "app/db/users/";
    private $file_name = "users.json";

    public function getUserById($id)
    {
        $query = array("function" => "checkId", "id" => $id);
        $table = $this->getJsonContentFromFile($this->file_name, $this->save_path);
        return $this->executeQuery($table, $query);
    }

    public function getUserByUsername($username)
    {
        $query = array("function" => "checkUsername", "column" => "username", "username" => $username);
        $table = $this->getJsonContentFromFile($this->file_name, $this->save_path);
        return $this->executeQuery($table, $query);
    }

    public function executeQuery($table, $query)
    {
        $function = $query["function"];
        return array_filter($table, $this->$function($query));
    }

    public function checkId($query)
    {
        return function(&$item) use ($query) {
            
            
            if ($item['id'] == $query['id']) {
                return $item;
            }
        };
    }

    public function checkUsername($query)
    {
        return function(&$item) use ($query) {
            
            echo  $item['username'];
            if ($item['username'] == $query['username']) {
                return $item;
            }
        };
    }

//    public function validateLogin($authentification_data = array())
//    {
//        $users_database = $this->getValidationValues($authentification_data);
//        $found_user = array_shift(array_filter($users_database, $this->checkPassword($authentification_data)));
//
//        if (!empty($found_user)) {
//            echo "te poti loga";
//            return true;
//        } else {
//            echo "nu te poti loga";
//            return false;
//        }
//    }
    //put your code here
}
