<?php

require './vendor/autoload.php';

class User extends BaseEntity implements AggregateRoot{
    private  string $fullname;
    private  string $email;
    private  string $password;
    private  string $activationCode;
    private  string $forgettenPasswordCode;
    private  bool   $isUserActiveted;
    private $refreshTokenModel;
    private  string $userRole;
    
    function __construct($uuid,$fullname,$email,$password,bool $isUserActiveted,$createdAt,$updatedAt)
    {
        parent::__construct($uuid, $createdAt, $updatedAt);
        if(!$fullname){
            throw new Exception('fullname must be not null, 400');
        }
        if(!$email){
            throw new Exception('email must be not null, 400');
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception('email is not valid, 400');
        }
        if(!$password){
            throw new Exception('password must be not null, 400');
        }
        if(strlen($password) < 6){
            throw new Exception('password length must be greater than 6, 400');
        }
        if(!isset($isUserActiveted) || !is_bool($isUserActiveted)){
            throw new Exception('activated bool value must be not null or must be boolean, 400');
        }
        
        $this->fullname = $fullname;
        $this->email = $email;
        $this->password = $password;
        $this->isUserActiveted = $isUserActiveted;
        $this->userRole = Role::STRAIGHT;
    }

    function changeFullName($newFullname){
        if(!$newFullname){
            throw new Exception('fullname must be not null, 400');
        }
        if($newFullname == $this->fullname){
            throw new Exception('new full name and actual full name is same which is not same, 400');
        }
        $this->fullname = $newFullname;

    }

    function hashPassword($userPassword){
        $this->password = md5($userPassword);
    }
    function createNewPassword($newPassword){
        if(!$newPassword){
            throw new Exception('password must be not null, 400');
        }
        if(strlen($newPassword) < 6){
            throw new Exception('password length must be greater than 6, 400');
        }
        if(md5($newPassword) == $this->password){
            throw new Exception('new password and actual password same which is not must be same, 400');
        }

        $this->hashPassword($newPassword);

    }
    function ChangePassword($oldPassword,$newPassword){
        if(md5($oldPassword) !== $this->password){
            throw new Exception('old password and actual is not same which is must be same, 400');
        }

        if(strlen($newPassword) < 6){
            throw new Exception('password length must be greater than 6, 400');
        }
        if(md5($newPassword) == $this->password){
            throw new Exception('new password and actual password same which is not must be same, 400');
        }
        $this->hashPassword($newPassword);
    }

    function comparePassword($fromBody):bool{
        if(md5($fromBody) == $this->password){
            return true;
        }else{
            throw new Exception('password incorrect try again, 400');
        }   
    }

    function isUserActiveted(){
        $bool = $this->getIsUserActiveted();
        if($bool == false){
            throw new Exception('user not activated, 400');
        }
        else{return true;}
    }

    function createForgettenPasswordCode(){
        $this->forgettenPasswordCode = password_hash(bin2hex(random_bytes(16)),PASSWORD_DEFAULT);
    }
    function createActivationCode(){
        $this->activationCode = password_hash(bin2hex(random_bytes(16)),PASSWORD_DEFAULT);
    }

        function setActivationCode($code){
            if(!$code){
                throw new Exception('Activation code must be not null, 400');
            }
            $this->activationCode = $code;
        }
        function setRefreshTokenModel(RefreshToken $refToken){
            if(!$refToken){
                throw new Exception('refresh token must be not null, 400'); 
            }
            $this->refreshTokenModel = $refToken;
    }
    
    public function setUserRole($userRole)
    {
        if(!$userRole){
            throw new Exception('user role must be not null, 400');
        }
        $this->userRole = $userRole;

    }


    function getRefreshTokenModel(){
        return $this->refreshTokenModel;
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

    function getForegettenPasswordCode(){
        return $this->forgettenPasswordCode;
    }
    /**
     * Set the value of userRole
     *
     */ 
    /**
     * Get the value of isUserActiveted
     */ 
    public function getIsUserActiveted()
    {
        return $this->isUserActiveted;
    }
}