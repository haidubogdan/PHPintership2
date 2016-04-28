<?php

namespace Quiz\models;

use Quiz\models\User as User;
use Quiz\models\DB as DB;

class AuthentificateModel extends RenderModel
{
    public $authentificated_user;    
    private $users_data_path = "app/db/users/";
    private $file_name = "users.json";
    private $error = 0;

    public function login()
    {
        if (RequestMethods::post("user_type")) {
            $this->data['username'] = $username = RequestMethods::post("username");
            $this->data['password'] = $password = RequestMethods::post("password");
            $this->data['user_type'] = $usertype = RequestMethods::post("user_type");
            $this->error = 0;
        }

        if (empty($username)) {
            $this->data["username_error"] = "Complete username";
            $this->error = 1;
        }
        if (empty($password)) {
            $this->data["password_error"] = "Complete password";
            $this->error = 1;
        }
        if (!$this->error&&!$this->validateLogin($this->data)) {
            $this->data["credential_error"] = "Wrong username / password";
            $this->error = 1;
        }

        if (!$this->error) {
            $user = new User();
            $user->setUsername($username);
            $user->setUserType($usertype);
            $this->authentificated_user = $user;
            var_dump($this->authentificated_user);
        } 
        $this->data['error'] = $this->error;
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
            $config [0] = include "config.php";
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
        $db = new DB();
        return $db->getJsonContentFromFile($this->file_name, $this->users_data_path);
    }

    public function startSession()
    {
        $user = $this->authentificated_user;
        $_SESSION['logged'] = 1;
        $_SESSION['user']['username'] = $user->getUsername();
        $test = $user->getUsername();
        var_dump($test);
        $start_session_name = $user->getUserType() . "Session";
        $this->$start_session_name();
     }

    public function descructSession()
    {
        session_destroy();
        header("Location:index.php?page=home");
    }

    public function AdministratorSession()
    {
        $_SESSION['admin'] = true;
        header("Location:index.php?page=admin");
    }

    public function normal_userSession()
    {
        header("Location:index.php?page=home");
    }

}
