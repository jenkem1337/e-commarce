<?php

class ProductSubscriberCreationalDto {
    protected $productUuid;

    protected $userUuid;

    protected $uuid;

    protected $createdAt;

    protected $updatedAt;

    public function __construct($uuid, $productUuid, $userUuid, $createdAt, $updatedAt)
    {
        $this->productUuid = $productUuid;
        $this->userUuid = $userUuid;
        $this->uuid = $uuid;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
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