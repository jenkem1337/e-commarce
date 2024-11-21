<?php

class OrderItemCollection implements IteratorAggregate {
    private array $orderItemCollection;
	function __construct() {
        $this->orderItemCollection = array();
	}
    function getItem($key){
        return $this->orderItemCollection[(string)$key] ?? new NullOrderItem();
    }
    function getItems():array{
        return $this->orderItemCollection;
    }
    function clearItems(){
        $this->orderItemCollection = array();
    }

    function add(OrderItem $orderItem):void{
        $this->orderItemCollection[(string)$orderItem->getUuid()] = $orderItem;
    }
	function getIterator():Iterator {
        return new ArrayIterator($this->orderItemCollection);
    }

}