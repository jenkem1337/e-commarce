<?php

class LengthMustBeGreaterThanException extends BaseException {
    function __construct($property, $minimumLength)
    {
        parent::__construct($property." length must be greater than ".$minimumLength, 400);
    }
}