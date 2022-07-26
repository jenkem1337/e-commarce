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
    function getItem($key):ProductSubscriberInterface{
        return $this->subscriberCollection[(string)$key] ?? new NullProductSubscriber();
    }
    function add(ProductSubscriberInterface $sub):void{
        $this->subscriberCollection[(string)$sub->getUuid()] = $sub; 
    }
    function getIterator(): Iterator
    {
        return new ArrayIterator($this->subscriberCollection);
    }

}