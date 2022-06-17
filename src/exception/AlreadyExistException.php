<?php
require "./vendor/autoload.php";

class AlreadyExistException extends BaseException {
    function __construct($property)
    {
        parent::__construct($property." already exist", 400);
    }
}