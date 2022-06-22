<?php

class Rate extends BaseEntity implements RateInterface{
    private string $pruductUuid;
    private string $userUuid;
    private int $rateNumber;
    private int $howManyPeopleRateIt;
    private float $avarageRate;
    
    function __construct(string $uuid,string $productUuid, $userUuid, int $rateNumber, $createdAt, $updatedAt)
    {
        parent::__construct($uuid, $createdAt, $updatedAt);
        if(!$userUuid){
            throw new NullException('user uuid');
        }
        if(!$productUuid){
            throw new NullException('product uuid');
        }
        if(!$rateNumber){
            throw new NullException('rate number');
        }
        
        if($rateNumber<0)   throw new NegativeValueException();
        if($rateNumber > 5) throw new LengthMustBeGreaterThanException('rate number', 5);
        
        
        $this->productUuid = $productUuid;
        $this->userUuid = $userUuid;
        $this->rateNumber = $rateNumber;

    }
    public function setHowManyPeopleRateIt($howManyPeopleRateIt)
    {
        if(!$howManyPeopleRateIt) throw new NullException('how many people rate it');
        $this->howManyPeopleRateIt = $howManyPeopleRateIt;
    }

    function calculateAvarageRate(int $sumOfRate){
        if(!$sumOfRate) throw new NullException('sum of rate');
        if($sumOfRate == 0 || $this->howManyPeopleRateIt == 0) {
            $this->howManyPeopleRateIt = 1;
        }
        $this->avarageRate =  $sumOfRate/$this->howManyPeopleRateIt;
    }

    /**
     * Get the value of pruductUuid
     */ 
    public function getPruductUuid()
    {
        return $this->pruductUuid;
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
     * Get the value of avaregeRate
     */ 
    public function getAvaregeRate()
    {
        return $this->avaregeRate;
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
     * Get the value of avarageRate
     */ 
    public function getAvarageRate()
    {
        return $this->avarageRate;
    }

    /**
     * Get the value of userUuid
     */ 
    public function getUserUuid()
    {
        return $this->userUuid;
    }
}