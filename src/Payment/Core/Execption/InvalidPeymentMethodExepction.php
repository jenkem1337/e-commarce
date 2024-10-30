<?php
class InvalidPeymentMethodExepction extends DomainException {
    function __construct( $message = "Unknown peyment method !", int $code = 400, Throwable $previous = null){
        parent::__construct($message, $code);
    }
}