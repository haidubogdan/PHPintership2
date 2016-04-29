<?php

namespace Quiz\Entitiy;

use Quiz\models\DB as DB;

/**
 * Description of UserRepository
 * Class used to connect to the users database and make changes if necessary
 * @author bogdanhaidu
 */
class UserRepository extends DB
{

    private $save_path = "app/db/users/";
    private $file_name = "users.json";
    public $file_permission;
    private $connected = 1;
    
    function __construct()
    {
        $files = scandir ($this->save_path);
        var_dump($files);
        if(!($key=array_search($this->file_name,$files))){
            $this->connected=0;
            echo "Warning!!! Database connection lost!";
        } else {
            $this->file_permission = substr(sprintf('%o', fileperms($this->save_path)), -4);
        }
    }
    
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

    public function getUserByEmail($email)
    {
        $query = array("function" => "checkEmail", "column" => "email", "email" => $email);
        $table = $this->getJsonContentFromFile($this->file_name, $this->save_path);
        return $this->executeQuery($table, $query);
    }

    public function getUsernameById($id)
    {
        $query = array("function" => "checkId", "id" => $id);
        $table = $this->getJsonContentFromFile($this->file_name, $this->save_path);
        return array_shift($this->executeQuery($table, $query))['username'];
    }
    public function getUsernameByEmail($email)
    {
        $query = array("function" => "checkEmail", "column" => "email", "email" => $email);
        $table = $this->getJsonContentFromFile($this->file_name, $this->save_path);
        return array_shift($this->executeQuery($table, $query))['username'];
    }
    public function getEmailById($id)
    {
        $query = array("function" => "checkId", "id" => $id);
        $table = $this->getJsonContentFromFile($this->file_name, $this->save_path);
        return array_shift($this->executeQuery($table, $query))['email'];
    }

    public function getIdByEmail($email)
    {
        $query = array("function" => "checkEmail", "column" => "email", "email" => $email);
        $table = $this->getJsonContentFromFile($this->file_name, $this->save_path);
        return array_shift($this->executeQuery($table, $query))['id'];
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

    public function checkEmail($query)
    {
        return function(&$item) use ($query) {

            if (array_key_exists('email', $item)) {
                if ($item['email'] == $query['email']) {
                    return $item;
                }
            }
        };
    }

    public function checkUsername($query)
    {
        return function(&$item) use ($query) {

            echo $item['username'];
            if ($item['username'] == $query['username']) {
                return $item;
            }
        };
    }

    public function insertUser($user)
    {
        date_default_timezone_set('Europe/Bucharest');
        $creation_date = array("date" => date('Y/m/d h:i:sa ', time()));
        $data = array("username" => $user->getUsername(),
            "email" => $user->getEmail(),
            "password" => $user->getPassword(),
            "user_type" => $user->getUserType(),
        );

        var_dump($data);
        $db = new DB ();
        if (!file_exists($this->save_path . $this->file_name)) {
            echo "File doesn't exist!!";
            $id = array("id" => 0);
            $new_data [] = $id + $data + $creation_date;
            $db->saveData($this->file_name, $this->save_path, $new_data);
            return 1;
        } else {
            echo "File exists!!";
            $new_data = $db->getJsonContentFromFile($this->file_name, $this->save_path);
            $id = array("id" => count($new_data));
            array_push($new_data, $id + $data + $creation_date);
            $db->saveData($this->file_name, $this->save_path, $new_data);
            return 1;
        }
    }

}
