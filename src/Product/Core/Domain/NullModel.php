<?php

class NullModel implements ModelInterface {
    function getName(){}
    function changeName($name){}
    function getBrandUuid(){}
    function isNull(){return true;}
    public function getUuid(){}

    public function getCreatedAt(){}

    public function getUpdatedAt(){}

}