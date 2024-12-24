<?php

use Ramsey\Uuid\Uuid;

class User extends BaseEntity implements AggregateRoot, UserInterface{
    private  string $fullname;
    private  string $email;
    private  string $password;
    private  string $activationCode;
    private  string $forgettenPasswordCode;
    private         $isUserActiveted;
    private  RefreshTokenInterface $refreshTokenModel;
    private  string $userRole;
    
    function __construct($uuid,$fullname,$email,$password, $isUserActiveted,$createdAt,$updatedAt)
    {
        parent::__construct($uuid, $createdAt, $updatedAt);
        if(!(trim($fullname))){
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
        else if(strlen(trim($password)) < 6){
            throw new LengthMustBeGreaterThanException('password', 6);
        }
        else if(!isset($isUserActiveted)){
            throw new NullException('activated bool');
        }
        
        $this->fullname = trim($fullname);
        $this->email = $email;
        $this->password = trim($password);
        $this->isUserActiveted = $isUserActiveted;
        $this->userRole = Role::STRAIGHT;
    }

    static function newInstance($uuid,$fullname,$email,$password, $isUserActiveted,$createdAt,$updatedAt):UserInterface {
        try {
            return new User($uuid,$fullname,$email,$password, $isUserActiveted,$createdAt,$updatedAt);
        } catch (\Throwable $th) {
            return new NullUser();
        }
    }
    static function newStrictInstance($uuid,$fullname,$email,$password, $isUserActiveted,$createdAt,$updatedAt):UserInterface {
        return new User($uuid,$fullname,$email,$password, $isUserActiveted,$createdAt,$updatedAt);
    }

    static function createNewUser($uuid, $fullname, $email, $password, $createdAt, $updatedAt):UserInterface {
        $user = new User($uuid,$fullname,$email,$password, 0 ,$createdAt,$updatedAt);
        
        $user->hashPassword($user->getPassword());
        
        $user->createActivationCode();

        $user->createRefreshTokenModel();

        $user->appendLog(new InsertLog("users", [
            "uuid" => $user->getUuid(),
            "full_name" => $user->getFullname(),
            "email" => $user->getEmail(),
            "user_password"=> $user->getPassword(),
            "is_user_activated" => $user->getIsUserActiveted(),
            "email_activation_code" => $user->getActivationCode(),
            "user_role" => $user->getUserRole(),
            "created_at" => $user->getCreatedAt(),
            "updated_at" => $user->getUpdatedAt()
        ]));
        return $user;
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
        if($bool == 0){
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
    function createRefreshTokenModel(){
        $refreshToken = RefreshToken::newStrictInstance(UUID::uuid4(), $this->getUuid(), date('Y-m-d H:i:s'), date('Y-m-d H:i:s'));
        
        $refreshToken->createRefreshToken(60*60*24*10);
        
        $this->refreshTokenModel = $refreshToken;    
    }
    function setRefreshToken(RefreshTokenInterface $refreshToken){
        $this->refreshTokenModel = $refreshToken;
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