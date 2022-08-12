<?php


class SamePropertyException extends BaseException{
    function __construct($property, $actualProperty)
    {
        parent::__construct($property." and actual ".$actualProperty." is same which must not be same", 400);
    }
}