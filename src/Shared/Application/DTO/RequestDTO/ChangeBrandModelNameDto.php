<?php

class ChangeBrandModelNameDto {
    private $brandUuid;
    private $modelUuid;
    private $name;

    function __construct($brandUuid, $modelUuid, $name){
        $this->brandUuid = $brandUuid;
        $this->modelUuid = $modelUuid;
        $this->name = $name;
    }
    function name(){return $this->name;}
    function brandUuid(){return $this->brandUuid;}
    function modelUuid(){return $this->modelUuid;}

}