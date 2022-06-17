<?php
require "./vendor/autoload.php";

class HttpMethodException extends BaseException {
    function __construct()
    {
        parent::__construct("matched route http method is not equal to actual http method",405);
    }
}