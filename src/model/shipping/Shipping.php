<?php

//this component development stage, not completed
class Shipping extends BaseEntity implements AggregateRoot, ShippingInterface {
    private $shippingType;
    private $price;
    private $shippingAddress;
    private $shippingState;
    private $whenWillFinish;
    function __construct($shippingType,$uuid, $price, $createdAt, $updatedAt)
    {
        if(!$shippingType) throw new NullException('shipping type');
        $this->shippingType = $shippingType;
        if(!$price) throw new NullException('price');
        if($price < 0) throw new NegativeValueException('price');
        $this->price = $price;
        parent::__construct($uuid, $createdAt, $updatedAt);

    }
    function setShippingAddress($shippingAddress){
        if(!$shippingAddress) throw new NullException('shipping address');
        $this->shippingAddress = $shippingAddress;

    }
    function changePrice($price){
        if(!$price) throw new NullException('price');
        if($price < 0) throw new NegativeValueException('price');
        $this->price = $price;
    }
    function changeShippingAddress($shippingAddress) {
        if(!$shippingAddress) throw new NullException('shipping address');
        $this->shippingAddress = $shippingAddress;
    }

    /**
     * Get the value of shippingType
     */ 
    public function getShippingType()
    {
        return $this->shippingType;
    }

    /**
     * Get the value of price
     */ 
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Get the value of shippingAddress
     */ 
    public function getShippingAddress()
    {
        return $this->shippingAddress;
    }

    /**
     * Get the value of shippingState
     */ 
    public function getShippingState()
    {
        return $this->shippingState;
    }

    /**
     * Get the value of whenWillFinish
     */ 
    public function getWhenWillFinish()
    {
        return $this->whenWillFinish;
    }
} 