<?php
class InvalidCartOwnerException extends DomainException {
    function __construct(string $message = "", int $code = 0, Throwable $previous = null){
        parent::__construct("Cart owner full name is not valid !", 400);
    }
}