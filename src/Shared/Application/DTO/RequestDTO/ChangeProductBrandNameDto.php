<?php

class ChangeProductBrandNameDto {
    protected $uuid;

    protected $newBrandName;

    public function __construct($uuid, $newBrandName)
    {
        $this->uuid = $uuid;
        $this->newBrandName = $newBrandName;
    }



    /**
     * Get the value of newBrandName
     */ 
    public function getNewBrandName()
    {
        return $this->newBrandName;
    }

    /**
     * Get the value of uuid
     */ 
    public function getUuid()
    {
        return $this->uuid;
    }
}