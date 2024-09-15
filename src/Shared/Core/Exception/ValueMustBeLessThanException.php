<?php
class ValueMustBeLessThanException extends BaseException {
    function __construct($property, $maxValue)
    {
        parent::__construct($property." value must be less than ".$maxValue, 400);
    }
}