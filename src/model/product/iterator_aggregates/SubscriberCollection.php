<?php
require './vendor/autoload.php';

class SubscriberCollection implements IteratorAggregate {
    private array $subscriberCollection;
    function __construct()
    {
        $this->subscriberCollection = array();
    }
    function getItems():array{
        return $this->subscriberCollection;
    }
    function getItem($key):SubscriberCollection{
        return $this->subscriberCollection[(string)$key];
    }
    function add(ProductSubscriberInterface $sub):void{
        $this->subscriberCollection[(string)$sub->getUuid()] = $sub; 
    }
    function getIterator(): Iterator
    {
        return new ArrayIterator($this->subscriberCollection);
    }

}