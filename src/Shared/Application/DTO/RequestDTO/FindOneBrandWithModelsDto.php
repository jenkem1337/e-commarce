<?php

class FindOneBrandWithModelsDto {
    private $uuid;
    function __construct($uuid) {
        $this->uuid = $uuid;
    }

    function uuid(){return $this->uuid;}
}