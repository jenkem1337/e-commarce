<?php
require './vendor/autoload.php';
use Ramsey\Uuid\Uuid;

abstract class BaseEntity {
    private $uuid;
    private $createdAt;
    private $updatedAt;

    function __construct($uuid, $createdAt, $updatedAt)
    {
        if(!$uuid){
            throw new Exception('uuid doesnt exist, 400');
        }
        if(!Uuid::isValid($uuid)){
            throw new Exception('uuid is not valid, 400');
        }
        if(!$createdAt){
            throw new Exception('create at doesnt exist, 400');

        }
        if(!$updatedAt){
            throw new Exception('updated at doesnt exist, 400');
        }

        $this->uuid = $uuid;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    /**
     * Get the value of uuid
     */ 
    public function getUuid()
    {
        return $this->uuid;
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