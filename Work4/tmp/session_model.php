<?php

namespace Quiz\models;

use Quiz\models\DB as DB;

class SessionModel
{

    public function __construct()
    {
        
    }

    public function startSession($user)
    {
        var_dump($user);
        $_SESSION['logged'] = 1;
        $_SESSION['user'] = $user;
        $start_session_name = $_SESSION['user']['user_type'] . "Session";
        //if (function_exists($start_session_name)) {
        $this->$start_session_name();
        //}
    }

    public function descructSession($user)
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
