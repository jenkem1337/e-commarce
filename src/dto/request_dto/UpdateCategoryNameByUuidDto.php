<?php

class UpdateCategoryNameByUuidDto {
    protected $uuid;

    protected $newCategoryName;

    public function __construct($uuid, $newCategoryName)
    {
        $this->uuid = $uuid;
        $this->newCategoryName = $newCategoryName;
    }



    /**
     * Get the value of uuid
     */ 
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * Get the value of newCategoryName
     */ 
    public function getNewCategoryName()
    {
        return $this->newCategoryName;
    }
}