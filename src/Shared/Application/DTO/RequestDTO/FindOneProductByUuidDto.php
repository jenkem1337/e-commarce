<?php

class FindOneProductByUuidDto {
    protected $uuid;
    protected $filter;

    public function __construct($uuid, $filter)
    {
        $this->uuid = $uuid;
        $this->filter = $filter;
    }



    /**
     * Get the value of uuid
     */ 
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * Get the value of filter
     */ 
    public function getFilter()
    {
        return $this->filter;
    }
}