<?php
require "./vendor/autoload.php";
class NullException extends BaseException {
    function __construct($property, $code = 400)
    {
        parent::__construct($property." must not be null",$code);
    }
}