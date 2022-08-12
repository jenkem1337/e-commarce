<?php
class IsNotSamePropertyException extends BaseException {
    function __construct($property, $actualProperty)
    {
        parent::__construct($property." and actual ".$actualProperty." is not same which is must be same", 400);
    }
}