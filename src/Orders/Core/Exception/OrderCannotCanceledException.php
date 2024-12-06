<?php

class OrderCannotCanceledException extends DomainException {
    function __construct(string $message = "", int $code = 0, Throwable $previous = null){
        parent::__construct($message, 400);
    }
}