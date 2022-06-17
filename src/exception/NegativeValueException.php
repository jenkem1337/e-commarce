<?php
require "./vendor/autoload.php";
class NegativeValueException extends BaseException {
    function __construct()
    {
        parent::__construct("value must not be negative value");
    }
}