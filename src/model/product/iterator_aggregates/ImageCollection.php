<?php
require './vendor/autoload.php';

class ImageCollection implements IteratorAggregate {
    private array $imageCollection;
    function __construct()
    {
        $this->imageCollection = array();
    }
    function getItems():array{
        return $this->imageCollection;
    }
    function getItem($key):ImageInterface{
        return $this->imageCollection[$key];
    }
    function add(ImageInterface $image):void{
        $this->imageCollection[$image->getUuid()] = $image; 
    }
    function getIterator(): Iterator
    {
        return new ArrayIterator($this->imageCollection);
    }

}