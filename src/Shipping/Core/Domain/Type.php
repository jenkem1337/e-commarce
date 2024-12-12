<?php
class Type {
    private $type;
    private $price;
    
    function __construct($type, $price){
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
    static function fromValue(string $value): Type {
        $type = null;
        
        switch($value) {
            case 'FREE':
                $type = new Type(ShippingType::FREE, 0);
                break;
            case 'PAIDED':
                $type = new Type(ShippingType::PAIDED, 40);
                break;
            default:
                throw new Exception("Unknown type");
        }
        return $type;
    }
    function getType() {return $this->type->name;}
    function getPrice() {return $this->price;}
}