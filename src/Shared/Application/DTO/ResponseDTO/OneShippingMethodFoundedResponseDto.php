<?php

class OneShippingMethodFoundedResponseDto extends ResponseViewModel implements JsonSerializable{
    protected $uuid;

    protected $type;

    protected $price;

    protected $createdAt;

    protected $updatedAt;

    public function __construct($uuid, $type, $price, $createdAt, $updatedAt)
    {
        $this->uuid = $uuid;
        $this->type = $type;
        $this->price = $price;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        parent::__construct('success', $this);
    }

    

    /**
     * Get the value of updatedAt
     */ 
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Get the value of price
     */ 
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Get the value of createdAt
     */ 
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Get the value of uuid
     */ 
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * Get the value of type
     */ 
    public function getType()
    {
        return $this->type;
    }

    function jsonSerialize(): mixed
    {
        return [
            'uuid'=>$this->getUuid(),
            'shipping_type' => $this->getType(),
            'price' => $this->getPrice(),
            'created_at'=>$this->getCreatedAt(),
            'updated_at'=> $this->getUpdatedAt()

        ];
    }
}