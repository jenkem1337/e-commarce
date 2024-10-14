<?php
class DeleteOneBrandModelDto {
    private $brandUuid;
    private $modelUuid;

    function __construct($brandUuid, $modelUuid, $name){
        $this->brandUuid = $brandUuid;
        $this->modelUuid = $modelUuid;
    }
    function brandUuid(){return $this->brandUuid;}
    function modelUuid(){return $this->modelUuid;}

}