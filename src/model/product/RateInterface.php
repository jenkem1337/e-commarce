<?php

interface RateInterface {
    public function setHowManyPeopleRateIt($howManyPeopleRateIt);
    function rateIt($rateNumber);

    public function getPruductUuid();

    public function getRateNumber();

    public function getHowManyPeopleRateIt();

    public function setUserUuid($userUuid);

    public function getUserUuid();

    public function getUuid();

    public function getCreatedAt();

    public function getUpdatedAt();

}