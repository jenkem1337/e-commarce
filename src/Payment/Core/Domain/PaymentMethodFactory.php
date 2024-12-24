<?php
class PaymentMethodFactory {
    static function fromValue(string $value):PaymentMethod{
        $method = null;
        switch($value) {
            case "CreditCard":
                $method = PaymentMethod::CreditCard;
                break;
            default: throw new Exception("Unknown method");
        }
        return $method;
    }
}