<?php
require "./vendor/autoload.php";


class NullRate implements RateInterface{
    private int $howManyPeopleRateIt;
    private int $avarageRate;
    
    function __construct()
    {
        $this->avarageRate = 0;
        $this->howManyPeopleRateIt = 0;
    }
    public function setHowManyPeopleRateIt($howManyPeopleRateIt)
    {
    }
    function setRateNumber($rateNumber){}
    function calculateAvarageRate(int $sumOfRate){}
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
        return $this->howManyPeopleRateIt;
    }

    /**
     * Get the value of avaregeRate
     */ 
    public function getAvaregeRate()
    {
        return $this->avarageRate;
    }

    /**
     * Set the value of userUuid
     *
     */ 
    public function setUserUuid($userUuid)
    {
    }

    /**
     * Get the value of avarageRate
     */ 
    public function getAvarageRate()
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