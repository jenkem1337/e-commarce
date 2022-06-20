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
    function getLastItem():ImageInterface{
        $lastItem = count($this->imageCollection) - 1;
        return $this->imageCollection[$lastItem];
    }
    function add(ImageInterface $image):void{
        $this->imageCollection[] = $image; 
    }
    function getIterator(): Iterator
    {
        return new ArrayIterator($this->imageCollection);
    }

}