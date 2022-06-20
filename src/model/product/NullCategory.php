<?php
require "./vendor/autoload.php";

class NullCategory implements CategoryInterface {
    function __construct()
    {
        
    }
    function setProductUuid($productUuid): void{}
    function changeCategoryName($categoryName){}

    public function getCategoryName(){}

    public function getProductUuid(){}
    
    public function getUuid(){}

    public function getCreatedAt(){}

    public function getUpdatedAt(){}

    function isNull(){
        return true;
    }


}