<?php
require "./vendor/autoload.php";


class NullRate implements RateInterface{
    function isNull()
    {
        return true;
    }
    function rateIt($rateNumber){}
    public function getPruductUuid()
    {
    }

    /**
     * Get the value of rateNumbers
     */ 
    public function getRateNumber()
    {
    }
    
    /**
     * Get the value of howManyPeopleRateIt
     */ 
    public function getHowManyPeopleRateIt()
    {
    }

    /**
     * Set the value of userUuid
     *
     */ 
    public function setUserUuid($userUuid)
    {
    }

    /**
     * Get the value of userUuid
     */ 
    public function getUserUuid()
    {
    }
    public function getUuid(){}

    public function getCreatedAt(){}

    public function getUpdatedAt(){}


}