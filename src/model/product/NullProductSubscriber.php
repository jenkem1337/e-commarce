<?php
require "./vendor/autoload.php";

class NullProductSubscriber implements ProductSubscriberInterface{
    function __construct()
    {
        
    }
    public function getProductUuid(){}

    public function getUserUuid(){}

    public function getUserEmail(){}

    public function getUserFullName(){}

    public function setUserFullName($userFullName){}

    public function setUserEmail($userEmail){}

    public function getUuid(){}

    public function getCreatedAt(){}

    public function getUpdatedAt(){}

    function isNull(){
        return true;
    }

}