<?php

class InvalidCartNumberException extends DomainException {
    function __construct(string $message = "", int $code = 0, Throwable $previous = null){
        parent::__construct("Cart number is not valid !", 400);
    }
}