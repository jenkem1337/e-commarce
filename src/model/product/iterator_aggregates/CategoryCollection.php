<?php
require "./vendor/autoload.php";

class CategoryCollection implements IteratorAggregate{
    private array $categoryCollection;
	function __construct() {
        $this->categoryCollection = array();
	}
    function getItem($key):CategoryInterface{
        return $this->categoryCollection[(string)$key] ?? new NullCategory();
    }
    function getItems():array{
        return $this->categoryCollection;
    }
    function add(CategoryInterface $category):void{
        $this->categoryCollection[(string)$category->getUuid()] = $category;
    }
	function getIterator():Iterator {
        return new ArrayIterator($this->categoryCollection);
    }
}