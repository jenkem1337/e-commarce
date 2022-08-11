<?php
class ChangeProductDescriptionDto {
    protected $uuid;

    protected $newDescription;

    public function __construct($uuid, $newDescription)
    {
        $this->uuid = $uuid;
        $this->newDescription = $newDescription;
    }



    /**
     * Get the value of newDescription
     */ 
    public function getNewDescription()
    {
        return $this->newDescription;
    }

    /**
     * Get the value of uuid
     */ 
    public function getUuid()
    {
        return $this->uuid;
    }
}