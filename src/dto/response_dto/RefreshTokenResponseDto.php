<?php

require './vendor/autoload.php';

class RefreshTokenResponseDto extends ResponseViewModel{
    protected $fullname;

    protected $email;
    
    protected $userRole;

    protected $refreshToken;

    protected $uuid;


    public function __construct($uuid,$fullname, $email, $userRole, $refreshToken)
    {
        $this->uuid = $uuid;
        $this->fullname = $fullname;
        $this->email = $email;
        $this->userRole = $userRole;
        $this->refreshToken= $refreshToken;
        parent::__construct('success', $this);
    }


    function getRefreshToken(){
        return $this->refreshToken;
    }
    /**
     * Get the value of uuid
     */ 
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * Get the value of isUserActivaed
     */ 
    public function getUserRole()
    {
        return $this->userRole;
    }

    /**
     * Get the value of email
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Get the value of fullname
     */ 
    public function getFullname()
    {
        return $this->fullname;
    }


}