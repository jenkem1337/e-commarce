<?php

class FindOneProductByUuidDto {
    protected $uuid;

    public function __construct($uuid)
    {
        $this->uuid = $uuid;
    }



    /**
     * Get the value of uuid
     */ 
    public function getUuid()
    {
        return $this->uuid;
    }
}