<?php
require './vendor/autoload.php';

class OneUserFoundedResponseDto extends ResponseViewModel{
    
    protected $fullName;

    protected $email;

    protected $password;

    protected $uuid;

    protected $userRole;

    protected $isUserActivated;

    protected $createdAt;

    protected $updatedAt;

    public function __construct($uuid,$fullName, $email, $password, $userRole, $isUserActivated, $createdAt, $updatedAt)
    {
        $this->uuid = $uuid;
        $this->fullName = $fullName;
        $this->email = $email;
        $this->password = $password;
        $this->userRole = $userRole;
        $this->isUserActivated = $isUserActivated;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        parent::__construct('success', $this);
    }



    /**
     * Get the value of fullName
     */ 
    public function getFullName()
    {
        return $this->fullName;
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
     * Get the value of uuid
     */ 
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * Get the value of userRole
     */ 
    public function getUserRole()
    {
        return $this->userRole;
    }

    /**
     * Get the value of isUserActivated
     */ 
    public function getIsUserActivated()
    {
        return $this->isUserActivated;
    }

    /**
     * Get the value of createdAt
     */ 
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Get the value of updatedAt
     */ 
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

}