<?php

class DoesNotExistException extends BaseException {
    function __construct($property, $code = 400)
    {
        parent::__construct($property." doesnt exist", $code);
    }
}
