<?php

class CreateBrandModelDto {
    private $brandUuid;
    private $modelName;

    function __construct($brandUuid, $modelName){
        $this->brandUuid = $brandUuid;
        $this->modelName = $modelName;
    }

    function brandUuid() {return $this->brandUuid;}
    function modelName(){return $this->modelName;}
}