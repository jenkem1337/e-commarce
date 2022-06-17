<?php
require "./vendor/autoload.php";
class UserRoleException extends BaseException {
    function __construct($property)
    {
        parent::__construct("user role must be ".$property, 403);
    }
}