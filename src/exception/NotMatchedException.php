<?php
require "./vendor/autoload.php";
class NotMatchedException extends BaseException {
    function __construct($property)
    {
        parent::__construct($property." not matched", 400);
    }
}