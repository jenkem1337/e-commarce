<?php
class NotValidException extends BaseException {
    function __construct($property)
    {
        parent::__construct($property." is not valid", 400);
    }
}