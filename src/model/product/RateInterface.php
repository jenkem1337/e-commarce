<?php

interface RateInterface {
    public function setHowManyPeopleRateIt($howManyPeopleRateIt);
    function setRateNumber($rateNumber);

    function calculateAvarageRate(int $sumOfRate);

    public function getPruductUuid();

    public function getRateNumber();

    public function getHowManyPeopleRateIt();

    public function getAvaregeRate();

    public function setUserUuid($userUuid);

    public function getAvarageRate();

    public function getUserUuid();

    public function getUuid();

    public function getCreatedAt();

    public function getUpdatedAt();

}