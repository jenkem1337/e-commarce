<?php
require "./vendor/autoload.php";

class ProductCollection implements IteratorAggregate{
    private array $productCollection;
	function __construct() {
        $this->productCollection = array();
	}
    function getItem($key):ProductInteface{
        return $this->productCollection[(string)$key];
    }
    function getItems():array{
        return $this->productCollection;
    }
    function add(ProductInteface $product):void{
        $this->productCollection[(string)$product->getUuid()] = $product;
    }
	function getIterator():Iterator {
        return new ArrayIterator($this->productCollection);
    }
}