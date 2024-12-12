<?php

class OrderStatusException extends DomainException {
    function __construct(string $message = "", int $code = 400, Throwable $previous = null){parent::__construct($message,$code);}
}