<?php
class ImageCreationalDto {

    protected ArrayIterator $imageIterator;
    protected $productUuid;

    public function __construct (ArrayIterator $imageIterator, $productUuid)
    {
        $this->imageIterator = $imageIterator;
        $this->productUuid =$productUuid;
    }


    /**
     * Get the value of imageIterator
     */ 
    public function getImageIterator()
    {
        return $this->imageIterator;
    }

    /**
     * Get the value of productUuid
     */ 
    public function getProductUuid()
    {
        return $this->productUuid;
    }
}