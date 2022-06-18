<?php

interface RateInterface {
    public function setHowManyPeopleRateIt($howManyPeopleRateIt);

    function calculateAvarageRate(int $sumOfRate, int $howManyPeopleRateIt);

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