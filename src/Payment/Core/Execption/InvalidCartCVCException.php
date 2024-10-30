<?php 
class InvalidCartCVCException extends DomainException {
    function __construct(string $message = "", int $code = 0, Throwable $previous = null){
        parent::__construct("Cart CVC number is not valid !", 400);
    }
}