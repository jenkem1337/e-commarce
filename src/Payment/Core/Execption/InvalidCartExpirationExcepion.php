<?php

class InvalidCartExpirationExcepion extends DomainException {
    function __construct(string $message = "", int $code = 0, Throwable $previous = null){
        parent::__construct("Cart expiration date is not valid !", 400);
    }
}