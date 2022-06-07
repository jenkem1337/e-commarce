<?php

require './vendor/autoload.php';

class User extends BaseEntity {
    private  string $fullname;
    private  string $email;
    private  string $password;

    
    function __construct($uuid,$fullname,$email,$password,$createdAt,$updatedAt)
    {
        parent::__construct($uuid, $createdAt, $updatedAt);
        if(!$fullname){
            throw new Exception('fullname must be not null');
        }
        if(!$email){
            throw new Exception('email must be not null');
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception('email is not valid');
        }
        
        if(!$password){
            throw new Exception('password must be not null');
        }

        if(strlen($password) < 6){
            throw new Exception('password length must be greater than 6');
        }
        $this->fullname = $fullname;
        $this->email = $email;
        $this->password = $password;
    }
    
    function hashPassword($userPassword){
        $this->password = md5($userPassword);
    }
    
    function ChangePassword($newPassword){
        if(strlen($newPassword) < 6){
            throw new Exception('password length must be greater than 6');
        }
        if(md5($newPassword) == $this->password){
            throw new Exception('new password and old password same which is not must be same');
        }
        $this->password = md5($newPassword);

    }

    function comparePassword($fromBody):bool{
        if(md5($fromBody) == $this->password){
            return true;
        }else{
            throw new Exception('password incorrect try again');
        }   
    }

    /**
     * Get the value of fullname
     */ 
    public function getFullname()
    {
        return $this->fullname;
    }

    /**
     * Get the value of email
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Get the value of password
     */ 
    public function getPassword()
    {
        return $this->password;
    }
}