<?php
require "./vendor/autoload.php";
class Category extends BaseEntity implements CategoryInterface{
    private $categoryName;
    private $productUuid;
    function __construct($uuid, $categoryName, $productUuid, $createdAt, $updatedAt)
    {
        parent::__construct($uuid, $createdAt, $updatedAt);
        if(!$categoryName) throw new NullException('category name');
        if(!$productUuid) throw new NullException('product uuid');
        $this->categoryName = $categoryName;
        $this->productUuid = $productUuid;
    }
    function changeCategoryName($categoryName){
        if(!$categoryName) throw new NullException('category name');

        $this->categoryName = $categoryName;

    }

    /**
     * Get the value of categoryName
     */ 
    public function getCategoryName()
    {
        return $this->categoryName;
    }

    /**
     * Get the value of productUuid
     */ 
    public function getProductUuid()
    {
        return $this->productUuid;
    }
}