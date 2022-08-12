<?php
use Ramsey\Uuid\Uuid;

abstract class BaseEntity {
    private $uuid;
    private $createdAt;
    private $updatedAt;

    function __construct($uuid, $createdAt, $updatedAt)
    {
        if(!$uuid){
            throw new NullException('uuid');
        }
        if(!Uuid::isValid($uuid)){
            throw new NotValidException('uuid');
        }
        if(!$createdAt){
            throw new NullException('create at');

        }
        if(!$updatedAt){
            throw new NullException('updated at');
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

    function isNull(){
        return false;
    }
}