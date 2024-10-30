<?php

use PHPUnit\Runner\BeforeTestHook;

class NullImage implements ImageInterface, NullEntityInterface {
    function __construct()
    {
        
    }
    public function getProductUuid(){}

    public function getImageName(){}

    public function getUuid(){}
    public function getLocation() {}

    public function getCreatedAt(){}

    public function getUpdatedAt(){}

    function isNull():bool{
        return true;
    }

}