<?php

require './vendor/autoload.php';

class User extends BaseEntity {
    private  string $fullname;
    private  string $email;
    private  string $password;
    private  string $activationCode;
    private  bool   $isUserActiveted;
    private  string $userRole;
    
    function __construct($uuid,$fullname,$email,$password,bool $isUserActiveted,$createdAt,$updatedAt)
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
        if(!isset($isUserActiveted) || !is_bool($isUserActiveted)){
            throw new Exception('activated bool value must be not null or must be boolean');
        }
        
        $this->fullname = $fullname;
        $this->email = $email;
        $this->password = $password;
        $this->isUserActiveted = $isUserActiveted;
        $this->userRole = Role::STRAIGHT;
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
        $this->hashPassword($newPassword);
    }

    function comparePassword($fromBody):bool{
        if(md5($fromBody) == $this->password){
            return true;
        }else{
            throw new Exception('password incorrect try again');
        }   
    }

    
    function createActivationCode(){
        $this->activationCode = password_hash(bin2hex(random_bytes(16)),PASSWORD_DEFAULT);
    }

    function setActivationCode($code){
        if(!$code){
            throw new Exception('Activation code must be not null');
        }
        $this->activationCode = $code;
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

    /**
     * Get the value of activationCode
     */ 
    public function getActivationCode()
    {
        return $this->activationCode;
    }

    
    /**
     * Get the value of userRole
     */ 
    public function getUserRole()
    {
        return $this->userRole;
    }

    /**
     * Set the value of userRole
     *
     */ 
    public function setUserRole(string $userRole)
    {
        if(!$userRole){
            throw new Exception('user role must be not null');
        }
        $this->userRole = $userRole;

    }

    /**
     * Get the value of isUserActiveted
     */ 
    public function getIsUserActiveted()
    {
        return $this->isUserActiveted;
    }
}