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
    function getLastItem():SubscriberCollection{
        $lastItem = count($this->subscriberCollection) - 1;
        return $this->subscriberCollection[$lastItem];
    }
    function add(ProductSubscriberInterface $sub):void{
        $this->subscriberCollection[] = $sub; 
    }
    function getIterator(): Iterator
    {
        return new ArrayIterator($this->subscriberCollection);
    }

}