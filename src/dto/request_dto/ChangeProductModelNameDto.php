<?php
class ChangeProductModelNameDto {
    protected $uuid;

    protected $newModelName;

    public function __construct($uuid, $newModelName)
    {
        $this->uuid = $uuid;
        $this->newModelName = $newModelName;
    }



    /**
     * Get the value of uuid
     */ 
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * Get the value of newModelName
     */ 
    public function getNewModelName()
    {
        return $this->newModelName;
    }
}