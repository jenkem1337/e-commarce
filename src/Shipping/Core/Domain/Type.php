<?php
class Type {
    private ShippingType $type;
    private $price;
    
    function __construct(ShippingType $type, $price){
        $this->type = $type;
        $this->price = $price;
    }
    static function fromOrderAmount($orderAmount): Type {
        $type = null;
        switch($orderAmount) {
            case $orderAmount >= 100:
                $type = new Type(ShippingType::FREE, 0);
                break;
            case $orderAmount < 100: 
                $type = new Type(ShippingType::PAIDED, 40);
                break; 
            default:
        }
        return $type;
    }
    function getType() {return $this->type->value;}
    function getPrice() {return $this->price;}
}