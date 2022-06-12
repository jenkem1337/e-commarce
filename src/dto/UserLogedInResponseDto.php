<?php

class UserLogedInResponseDto {
    protected $fullname;

    protected $email;
    
    protected $userRole;

    protected $refreshToken;

    protected $uuid;

    protected $isSuccess;

    public function __construct($isSuccess,$uuid,$fullname, $email, $userRole, $refreshToken)
    {
        $this->isSuccess = $isSuccess;
        $this->uuid = $uuid;
        $this->fullname = $fullname;
        $this->email = $email;
        $this->userRole = $userRole;
        $this->refreshToken= $refreshToken;
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

    public function isSuccess()
    {
        return $this->isSuccess;
    }

}