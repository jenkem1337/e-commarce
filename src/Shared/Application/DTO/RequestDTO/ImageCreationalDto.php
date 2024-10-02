<?php
class ImageCreationalDto {

    private $images;
    protected $productUuid;

    public function __construct ($images, $productUuid)
    {
        $this->images = $images;
        $this->productUuid =$productUuid;
    }


    /**
     */ 
    public function getImages()
    {
        return $this->images;
    }

    /**
     * Get the value of productUuid
     */ 
    public function getProductUuid()
    {
        return $this->productUuid;
    }
}