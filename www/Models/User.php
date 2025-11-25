<?php

namespace App\Model;


class User
{
    protected $id;
    protected $name;
    protected $email;
    protected $password;

    function setName($name){
        $this->name = $name;
    }

    function setEmail($email){
        $this->email = $email;
    }
    
    function setPassword($password){
        $this->password = $password;
    }

    function getId(){ 
        return $this->id;
    }

    function getName(){
        return $this->name;
    }
    function getEmail(){
        return $this->email;
    }

    function getPassword(){
        return $this->password;
    }
}  