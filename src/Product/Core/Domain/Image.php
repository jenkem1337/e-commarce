<?php 

class Image extends BaseEntity implements ImageInterface{
    private $productUuid;
    private $imageName;

    function __construct($uuid, $productUuid, $imageName, $createdAt, $updatedAt){
        parent::__construct($uuid, $createdAt, $updatedAt);
        if(!$productUuid) throw new NullException('product uuid');
        if(!$imageName) throw new NullException('image name');
        $this->productUuid = $productUuid;
        $this->imageName = $imageName;
    }
    /**
     * Get the value of productUuid
     */ 
    public function getProductUuid()
    {
        return $this->productUuid;
    }

    /**
     * Get the value of imageName
     */ 
    public function getImageName()
    {
        return $this->imageName;
    }
}