<?php
class ImageCreationalDto {
    protected array $images;

    protected $productUuid;

    public function __construct ($images, $productUuid)
    {
        $this->images = $images;
        $this->productUuid = $productUuid;
    }

    function getImages(){
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