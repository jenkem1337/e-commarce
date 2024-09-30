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
    public static function newInstance($uuid, $productUuid, $imageName, $createdAt, $updatedAt):ImageInterface {
        try {
            return new Image($uuid, $productUuid, $imageName, $createdAt, $updatedAt);
        } catch (\Throwable $th) {
            return new NullImage();
        }
    }
    public static function newStrictInstance($uuid, $productUuid, $imageName, $createdAt, $updatedAt):ImageInterface {
        return new Image($uuid, $productUuid, $imageName, $createdAt, $updatedAt);
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