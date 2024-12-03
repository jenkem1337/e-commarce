<?php

class ShippingHasNotDeliveredException extends DomainException {
    function __construct(string $message = "", int $code = 400, Throwable $previous = null){
        parent::__construct("The shipment has not been delivered.");
    }
}