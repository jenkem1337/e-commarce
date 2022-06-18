<?php

use FFI\Exception;

require './vendor/autoload.php';

class User extends BaseEntity implements AggregateRoot, UserInterface{
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
            throw new NullException('full name');
        }
        else if(!$email){
            throw new NullException('email');
        }
        else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new NotValidException('email');
        }
        else if(!$password){
            throw new NullException('password');
        }
        else if(strlen($password) < 6){
            throw new LengthMustBeGreaterThanException('password', 6);
        }
        else if(!isset($isUserActiveted) || !is_bool($isUserActiveted)){
            throw new NullException('activated bool');
        }
        
        $this->fullname = $fullname;
        $this->email = $email;
        $this->password = $password;
        $this->isUserActiveted = $isUserActiveted;
        $this->userRole = Role::STRAIGHT;
    }

    function changeFullName($newFullname){
        if(!$newFullname){
            throw new NullException('full name');
        }
        if($newFullname == $this->fullname){
            throw new SamePropertyException('new full name', "full name");
        }
        $this->fullname = $newFullname;

    }

    function hashPassword($userPassword){
        $this->password = md5($userPassword);
    }

    function createNewPassword($newPassword){
        if(!$newPassword){
            throw new NullException('password');
        }
        if(strlen($newPassword) < 6){
            throw new LengthMustBeGreaterThanException('password', 6);
        }
        if(md5($newPassword) == $this->password){
            throw new SamePropertyException("new password", "password");
        }

        $this->hashPassword($newPassword);

    }

    function ChangePassword($oldPassword,$newPassword){
        if(!$oldPassword) {
            throw new NullException('old password');
        }
        if(!$newPassword){
            throw new NullException('new password');
        }
        if(md5($newPassword) == $this->password){
            throw new SamePropertyException('new password', 'password');
        }

        if(md5($oldPassword) !== $this->password){
            throw new IsNotSamePropertyException('old password','password');
        }

        if(strlen($newPassword) < 6){
            throw new LengthMustBeGreaterThanException('password', 6);
        }
        $this->hashPassword($newPassword);
    }

    function comparePassword($fromBody):bool{
        if(md5($fromBody) == $this->password){
            return true;
        }else{
            throw new IncorrectException('password');
        }   
    }

    function isUserActiveted(){
        $bool = $this->getIsUserActiveted();
        if($bool == false){
            throw new NotActivatedException('user');
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
                throw new NullException('Activation code');
            }
            $this->activationCode = $code;
    }
    function setRefreshTokenModel(RefreshToken $refToken){
        if(!$refToken){
            throw new NullException('refresh token'); 
        }
        $this->refreshTokenModel = $refToken;
    }
    
    public function setUserRole($userRole)
    {
        if(!$userRole){
            throw new NullException('user role');
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
     * Get the value of isUserActiveted
     */ 
    public function getIsUserActiveted()
    {
        return $this->isUserActiveted;
    }
}