<?php
require "./vendor/autoload.php";

class NotActivatedException extends BaseException {
    function __construct($property)
    {
        parent::__construct($property." not activated", 400);
    }
}