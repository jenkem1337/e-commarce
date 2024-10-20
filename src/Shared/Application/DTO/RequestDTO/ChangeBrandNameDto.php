<?php
class ChangeBrandNameDto{
    private $uuid;
    private $name;

    function __construct($uuid, $name){
        $this->uuid = $uuid;
        $this->name = $name;
    }
    function name(){return $this->name;}
    function uuid(){return $this->uuid;}
}