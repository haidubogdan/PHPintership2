<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Quiz\models;

/**
 * Description of User
 *
 * @author bogdanhaidu
 */
class User
{

    private $id;
    private $username;
    private $password;
    private $usertype;

    public function setId($id)
    {
        $this->id = $id;
    }   
    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setPassword($password)
    {
        $this->password = password_hash($password,PASSWORD_DEFAULT);
    }
    public function getPassword()
    {
        return $this->password;
    }
    public function setUserType($user_type)
    {
        $this->usertype = $user_type;
    }

    public function getUserType()
    {
        return $this->usertype;
    }
    
}
