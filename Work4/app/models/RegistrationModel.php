<?php

namespace Quiz\models;

use Quiz\models\User as User;
use Quiz\models\DB as DB;

class RegistrationModel extends RenderModel
{

    public $registered_user;
    private $users_data_path = "app/db/users/";
    private $file_name = "users.json";
    private $error = 0;
    private $username_check_pattern = array(array("pattern" => "^[\w-@._]{30,}$", "error" => "username too long, maximum 30 characters are allowed!"),
        array("pattern" => "^[\w-@._]{0,5}$", "error" => "username too short, mimimum 6 character are allowed!"),
        array("pattern" => "^[\W\d][\w-@._]{5,30}$", "error" => "Name should beggin with a letter!"),
        array("pattern" => "[\D]{5,30}", "error" => "illegal characters, only '@','-','.','_' are allowed!"),
    );
    private $password_check_pattern = array(array("pattern" => "^[\w\W]{0,6}$", "error" => "Password too short!, minimum 6 characters are allowed"),
        array("pattern" => "^[\w\W]{16,}$", "error" => "Password too long, maximum 16 characters are allowed!"),
    );

    public function registrate()
    {
        if (RequestMethods::post("user_type")) {
            $this->data['username'] = $username = RequestMethods::post("username");
            $this->data['password'] = $password = RequestMethods::post("password");
            $this->data['user_type'] = $usertype = RequestMethods::post("user_type");
            $this->error = 0;
            $this->data['register'] = 1;
        }

        if (empty($username)) {
            $this->data["username_error"] = "Complete username!";
            $this->error = 1;
        } else {
            $this->validateName($username);
        }
        if (empty($password)) {
            $this->data["password_error"] = "Complete password!";
            $this->error = 1;
            //VALIDATE PASSWORD >HANDLE
        } else {
            $this->validatePassword($password);
        }

        if (!$this->error) {
            $user = new User();
            $user->setUsername($username);
            $user->setUserType($usertype);
            $user->setPassword($password);
            $this->registered_user = $user;
            var_dump($this->registered_user);
        }
        $this->data['error'] = $this->error;
    }

    public function validateName($username = "string")
    {
        if (!preg_match('/^[A-z]\S[\w-@._]{4,30}$/', $username)) {
            foreach ($this->username_check_pattern as $key => $values) {
                $pattern = $values ["pattern"];
                var_dump(preg_match('/' . $pattern . '/', $username));
                if (preg_match('/' . $pattern . '/', $username)) {
                    $this->data["username_error"] = $values ["error"] . "<br>";
                    $this->error=1;
                    break;
                }
            }
        }
    }

    public function validatePassword($password = "string")
    {

        if (!preg_match('/^[\w\W]{6,16}$/', $password)) {
            foreach ($this->password_check_pattern as $key => $values) {
                $pattern = $values ["pattern"];
                var_dump(preg_match('/' . $pattern . '/', $password));
                if (preg_match('/' . $pattern . '/', $password)) {
                    $this->data["password_error"] = $values ["error"];
                    $this->error=1;
                    break;
                }
            }
        }
    }

    public function insertUser()
    {
        $user = $this->registered_user;
        date_default_timezone_set('Europe/Bucharest');
        $creation_date = array("date" => date('Y/m/d h:i:sa ', time()));
        $data = array("username" => $user->getUsername(),
            "password" => $user->getPassword(),
            "user_type" => $user->getUserType(),
        );

        var_dump($data);
        $db = new DB ();
        if (!file_exists($this->users_data_path . $this->file_name)) {
            echo "File doesn't exist!!";
            $this->registered_user->setId(0);
            $id = array("id" => 0);
            $new_data [] = $id + $data + $creation_date;
            $db->saveData($this->file_name, $this->users_data_path, $new_data);
            return 1;
        } else {
            echo "File exists!!";
            $new_data = $db->getJsonContentFromFile($this->file_name, $this->users_data_path);
            $this->registered_user->setId(count($new_data));
            $id = array("id" => count($new_data));
            array_push($new_data, $id + $data + $creation_date);
            $db->saveData($this->file_name, $this->users_data_path, $new_data);
    
            return 1;
            
        }
    }

    public function getRegisteredUsers()
    {
        $db = new DB();
        return $db->getJsonContentFromFile($this->file_name, $this->users_data_path);
    }

    public function startSession()
    {
        $user = $this->registered_user;
        $_SESSION['logged'] = 1;
        $_SESSION['user']['username'] = $user->getUsername();
        $test = $user->getUsername();
        var_dump($test);
        $start_session_name = $user->getUserType() . "Session";
        $this->$start_session_name();
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
