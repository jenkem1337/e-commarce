<?php

class Rate extends BaseEntity implements RateInterface{
    private $productUuid;
    private $userUuid;
    private $rateNumber;
    private $howManyPeopleRateIt;
    
    function __construct($uuid, $productUuid, $userUuid, $createdAt, $updatedAt)
    {
        parent::__construct($uuid, $createdAt, $updatedAt);
        if(!$userUuid){
            throw new NullException('user uuid');
        }
        if(!$productUuid){
            throw new NullException('product uuid');
        }
        $this->productUuid = $productUuid;
        $this->userUuid = $userUuid;
    }
    function rateIt($rateNumber){
        if(!$rateNumber)    throw new NullException('rate number');
        if($rateNumber<0)   throw new NegativeValueException();
        if($rateNumber > 5) throw new ValueMustBeLessThanException('rate number', 5);

        $this->rateNumber = $rateNumber;
    }
    public static function newInstance($uuid, $productUuid, $userUuid, $createdAt, $updatedAt):RateInterface {
        try {
            return new Rate($uuid, $productUuid, $userUuid, $createdAt, $updatedAt);
        } catch (\Throwable $th) {
            return new NullRate();
        }
    }
    public static function newStrictInstance($uuid, $productUuid, $userUuid, $createdAt, $updatedAt):RateInterface {
        return new Rate($uuid, $productUuid, $userUuid, $createdAt, $updatedAt);
    }
    /**
     * Get the value of pruductUuid
     */ 
    public function getPruductUuid()
    {
        return $this->productUuid;
    }

    /**
     * Get the value of rateNumbers
     */ 
    public function getRateNumber()
    {
        return $this->rateNumber;
    }

    /**
     * Get the value of howManyPeopleRateIt
     */ 
    public function getHowManyPeopleRateIt()
    {
        return $this->howManyPeopleRateIt;
    }


    /**
     * Set the value of userUuid
     *
     */ 
    public function setUserUuid($userUuid)
    {
        $this->userUuid = $userUuid;
    }

    /**
     * Get the value of userUuid
     */ 
    public function getUserUuid()
    {
        return $this->userUuid;
    }
}