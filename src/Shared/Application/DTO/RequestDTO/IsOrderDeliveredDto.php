<?php 

class IsOrderDeliveredDto {
    function __construct(private $uuid){}

    /**
     * Get the value of uuid
     */ 
    public function getUuid()
    {
        return $this->uuid;
    }
}