<?php

class DeleteImageByUuidDto {
    protected $productUuid;

    protected $imageUuid;

    public function __construct($productUuid, $imageUuid)
    {
        $this->productUuid = $productUuid;
        $this->imageUuid = $imageUuid;
    }



    /**
     * Get the value of productUuid
     */ 
    public function getProductUuid()
    {
        return $this->productUuid;
    }

    /**
     * Get the value of imageUuid
     */ 
    public function getImageUuid()
    {
        return $this->imageUuid;
    }
}