<?php

class RateCollection implements IteratorAggregate {
    private array $rateCollection;
	function __construct() {
        $this->rateCollection = array();
	}
    function getItem($key):RateInterface{
        return $this->rateCollection[(string)$key] ?? new NullRate();
    }
    function getItems():array{
        return $this->rateCollection;
    }
    function clearItems(){
        $this->rateCollection = array();
    }

    function add(RateInterface $rate):void{
        $this->rateCollection[(string)$rate->getUuid()] = $rate;
    }
	function getIterator():Iterator {
        return new ArrayIterator($this->rateCollection);
    }
}