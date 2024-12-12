<?php

class ShippingStatusFactory {
    static function fromValue(string $value): ShippingState {
        $status = null;
        switch($value) {
            case "PENDING": 
                $status = ShippingState::PENDING;
                break;
            case "DISPATCHED":
                $status = ShippingState::DISPATCHED;
                break;
            case "DELIVERED":
                $status = ShippingState::DELIVERED;
                break;
            case "CANCELED":
                $status = ShippingState::CANCELED;
                break;
            default: throw new Exception("Unknown status");
        
        }
        return $status;
    }
}