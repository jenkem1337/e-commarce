<?php
require "./vendor/autoload.php";

class NullImage implements ImageInterface {
    function __construct()
    {
        
    }
    public function getProductUuid(){}

    public function getImageName(){}

    public function getUuid(){}

    public function getCreatedAt(){}

    public function getUpdatedAt(){}

    function isNull(){
        return true;
    }

}