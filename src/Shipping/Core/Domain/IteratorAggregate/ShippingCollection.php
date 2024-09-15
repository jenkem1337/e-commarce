<?php

class ShippingCollection implements IteratorAggregate{
    private array $shippingCollection;
	function __construct() {
        $this->shippingCollection = array();
	}
    function getItem($key):ShippingInterface{
        return $this->shippingCollection[(string)$key] ?? new NullShipping;
    }
    function getItems():array{
        return $this->shippingCollection;
    }
    function clearItems(){
        $this->shippingCollection = array();
    }

    function add(ShippingInterface $product):void{
        $this->shippingCollection[(string)$product->getUuid()] = $product;
    }
	function getIterator():Iterator {
        return new ArrayIterator($this->shippingCollection);
    }
}