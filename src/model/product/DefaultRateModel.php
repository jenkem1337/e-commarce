<?php

class DefaultRateModel implements RateInterface {
    
    private $avarageRate;
    private $howManyPeopleRateIt;
	/**
	 */
    function setHowManyPeopleRateIt($howManyPeopleRateIt) {
        if($howManyPeopleRateIt === 0){
            $this->howManyPeopleRateIt = $howManyPeopleRateIt;
            return;
        }
        if(!$howManyPeopleRateIt) throw new NullException('how many people rate it');
        $this->howManyPeopleRateIt = $howManyPeopleRateIt;

	}
	
	/**
	 *
	 * @param mixed $rateNumber
	 *
	 * @return mixed
	 */
	function rateIt($rateNumber) {
	}
	
	/**
	 *
	 * @param int $sumOfRate
	 *
	 * @return mixed
	 */
	function calculateAvarageRate(int $sumOfRate) {
        if($sumOfRate === 0){
            if($sumOfRate == 0 || $this->howManyPeopleRateIt == 0) {
                $this->howManyPeopleRateIt = 1;
            }
            $this->avarageRate =  $sumOfRate/$this->howManyPeopleRateIt;
            return;
        }
        if(!$sumOfRate) throw new NullException('sum of rate');
        $this->avarageRate =  $sumOfRate/$this->howManyPeopleRateIt;

	}
	
	/**
	 *
	 * @return mixed
	 */
	function getPruductUuid() {
	}
	
	/**
	 *
	 * @return mixed
	 */
	function getRateNumber() {
	}
	
	/**
	 *
	 * @return mixed
	 */
	function getHowManyPeopleRateIt() {
	}
	
	/**
	 *
	 * @return mixed
	 */
	function getAvaregeRate() {
        return $this->avarageRate;
	}
	
	/**
	 *
	 * @param mixed $userUuid
	 *
	 * @return mixed
	 */
	function setUserUuid($userUuid) {
	}
	
	/**
	 *
	 * @return mixed
	 */
	function getAvarageRate() {
	}
	
	/**
	 *
	 * @return mixed
	 */
	function getUserUuid() {
	}
	
	/**
	 *
	 * @return mixed
	 */
	function getUuid() {
	}
	
	/**
	 *
	 * @return mixed
	 */
	function getCreatedAt() {
	}
	
	/**
	 *
	 * @return mixed
	 */
	function getUpdatedAt() {
	}
}