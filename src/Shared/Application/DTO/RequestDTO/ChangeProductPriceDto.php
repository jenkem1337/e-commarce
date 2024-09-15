<?php
class ChangeProductPriceDto {
    protected $uuid;

    protected $newPrice;

    public function __construct($uuid, $newPrice)
    {
        $this->uuid = $uuid;
        $this->newPrice = $newPrice;
    }



    /**
     * Get the value of uuid
     */ 
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * Get the value of newPrice
     */ 
    public function getNewPrice()
    {
        return $this->newPrice;
    }
}