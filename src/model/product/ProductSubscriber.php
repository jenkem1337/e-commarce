<?php
require "./vendor/autoload.php";

class ProductSubscriber extends BaseEntity {
    private $productUuid;
    private $userUuid;
    private $userEmail;
    private $userFullName;

    function __construct($uuid,$productUuid,$userUuid,$createdAt,$updatedAt)
    {
        parent::__construct($uuid,$createdAt, $updatedAt);
        if(!$productUuid) throw new NullException('product uuid');
        if(!$userUuid)    throw new NullException('user uuid');
        $this->productUuid = $productUuid;
        $this->userUuid = $userUuid; 
    }
    /**
     * Get the value of productUuid
     */ 
    public function getProductUuid()
    {
        return $this->productUuid;
    }

    /**
     * Get the value of userUuid
     */ 
    public function getUserUuid()
    {
        return $this->userUuid;
    }

    /**
     * Get the value of userEmail
     */ 
    public function getUserEmail()
    {
        return $this->userEmail;
    }

    /**
     * Get the value of userFullName
     */ 
    public function getUserFullName()
    {
        return $this->userFullName;
    }

    /**
     * Set the value of userFullName
     *
     */ 
    public function setUserFullName($userFullName)
    {
        if($userFullName) throw new NullException('user full name');

        $this->userFullName = $userFullName;

    }

    /**
     * Set the value of userEmail
     *
     */ 
    public function setUserEmail($userEmail)
    {
        if($userEmail) throw new NullException('user mail');
        $this->userEmail = $userEmail;

    }
}