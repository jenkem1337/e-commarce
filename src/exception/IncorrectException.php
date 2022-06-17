<?php
require "./vendor/autoload.php";
class IncorrectException extends BaseException {
    function __construct($property)
    {
        parent::__construct($property." incorrect try again",400);
    }
}