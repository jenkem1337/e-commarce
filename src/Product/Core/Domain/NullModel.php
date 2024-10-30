<?php

class NullModel implements ModelInterface, NullEntityInterface {
    function getName(){}
    function changeName($name){}
    function getBrandUuid(){}
    function isNull():bool{return true;}
    public function getUuid(){}

    public function getCreatedAt(){}

    public function getUpdatedAt(){}

}