<?php

class ChangeProductHeaderDto {
    protected $uuid;

    protected $newHeaderName;

    public function __construct($uuid, $newHeaderName)
    {
        $this->uuid = $uuid;
        $this->newHeaderName = $newHeaderName;
    }



    /**
     * Get the value of uuid
     */ 
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * Get the value of newHeaderName
     */ 
    public function getNewHeaderName()
    {
        return $this->newHeaderName;
    }
}