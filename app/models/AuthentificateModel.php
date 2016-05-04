<?php

namespace Quiz\models;

use Quiz\models\User as User;
use Quiz\models\DB as DB;
use Quiz\Entitiy\UserRepository as UserRepository;

class AuthentificateModel extends RenderModel
{

    public $authentificated_user;
    private $users_data_path = "app/db/users/";
    private $file_name = "users.json";
    private $error = 0;

    public function login()
    {
        if (RequestMethods::post("user_type")) {
            $this->data['email'] = $email = RequestMethods::post("email");
            $this->data['password'] = $password = RequestMethods::post("password");
            $this->data['user_type'] = $usertype = RequestMethods::post("user_type");
            $this->error = 0;
        }

        if (empty($email)) {
            $this->data["email_error"] = "Complete email";
            $this->error = 1;
        }
        if (empty($password)) {
            $this->data["password_error"] = "Complete password";
            $this->error = 1;
        }
        if (!$this->error && !$this->validateLogin($this->data)) {
            $this->data["credential_error"] = "Wrong email / password";
            $this->error = 1;
        }

        if (!$this->error) {
            $user = new User();
            $user->setEmail($email);
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

            if (array_key_exists('email', $item)) {
                if ($item['email'] == $data['email'] && password_verify($data['password'], $item['password'])) {
                    $data['password'] = $item['password'];
                    return $item;
                }
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
        $user_repository = new UserRepository ();
        $user = $this->authentificated_user;
        $email = $user->getEmail();
        $_SESSION['logged'] = 1;
        $username = $user_repository->getUsernameByEmail($email);
        $_SESSION['user']['id'] = $user_repository->getIdByEmail($email);
        $_SESSION['user']['username'] = $username;
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
        $_SESSION['user']['username'] = 'Admin';
        header("Location:index.php?page=admin");
    }

    public function normal_userSession()
    {
        header("Location:index.php?page=home");
    }

}
