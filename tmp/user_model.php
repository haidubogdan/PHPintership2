<?php

namespace Quiz\models;

use Quiz\models\DB as DB;

class UserModel extends DB
{

    protected $id;
    protected $username;
    protected $password;
    protected $creation_date;
    protected $authentification_data = array();
    private $users_data_path = "app/db/users/";
    private $file_name = "users.json";

    public function checkPostValues()
    {
        $login_args = array(
            'username' => "FILTER_SANITIZE_SPECIAL_CHARS",
            'password' => "FILTER_SANITIZE_SPECIAL_CHARS",
            'user_type' => "FILTER_SANITIZE_SPECIAL_CHARS",
        );
        $login_inputs = filter_input_array(INPUT_POST, $login_args);
        return $this->authentification_data = $login_inputs;
    }

    public function register()
    {
        $username = filter_input(INPUT_POST, 'username');
        $password = password_hash(filter_input(INPUT_POST, 'password'), PASSWORD_DEFAULT);
        $usertype = filter_input(INPUT_POST, 'user_type');
        //var_dump($_POST);
        $this->authentification_data = $authentification_data = array("user_type" => $usertype, "username" => $username, "password" => $password);
        $this->insertUser($authentification_data);
    }

    public function insertUser($data)
    {
        if (!file_exists($this->users_data_path . $this->file_name)) {
            echo "File doesn't exist!!";
            $id = array("id" => 0);
            $new_data [] = $id + $data;
            $this->saveData($this->file_name, $this->users_data_path, $new_data);
        } else {
            echo "File exists!!";
            $new_data = $this->getJsonContentFromFile($this->file_name, $this->users_data_path);
            $id = array("id" => count($new_data) + 1);
            array_push($new_data, $id + $data);
            $this->saveData($this->file_name, $this->users_data_path, $new_data);
            return 1;
        }
    }

    public function validateLogin($authentification_data = array())
    {
        $users_database = $this->getValidationValues($authentification_data);
        $found_user = array_shift(array_filter($users_database, $this->checkPassword($authentification_data)));

        if (!empty($found_user)) {
            echo "te poti loga";
            return true;
        } else {
            echo "nu te poti loga";
            return false;
        }
    }

    private function getValidationValues($authentification_data)
    {
        if ($authentification_data["user_type"] == "administrator") {
            $config [0]=include "config.php";
            return $config;
        } else if ($authentification_data["user_type"] == "normal_user") {
            return $this->getRegisteredUsers();
        }
    }

    public function checkPassword($data)
    {
        return function(&$item) use ($data) {

            if ($item['username'] == $data['username'] && password_verify($data['password'], $item['password'])) {
                $data['password'] = $item['password'];
                return $item;
            }
        };
    }

    public function getRegisteredUsers()
    {
        return $this->getJsonContentFromFile($this->file_name, $this->users_data_path);
    }

    public function getAutehntificationData()
    {
        return $this->authentification_data;
    }

}
