<?php
require "./vendor/autoload.php";

class NotFoundException extends BaseException {
    function __construct($property, $code = 400)
    {
        parent::__construct($property." not found", $code);
    }
}