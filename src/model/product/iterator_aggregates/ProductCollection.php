<?php
require "./vendor/autoload.php";

class ProductCollection implements IteratorAggregate{
    private array $productCollection;
	function __construct() {
        $this->productCollection = array();
	}
    function getItem($key):ProductInterface{
        return $this->productCollection[(string)$key] ?? new NullProduct();
    }
    function getItems():array{
        return $this->productCollection;
    }
    function add(ProductInterface $product):void{
        $this->productCollection[(string)$product->getUuid()] = $product;
    }
	function getIterator():Iterator {
        return new ArrayIterator($this->productCollection);
    }
}