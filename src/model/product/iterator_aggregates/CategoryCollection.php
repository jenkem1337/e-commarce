<?php
require "./vendor/autoload.php";

class CategoryCollection implements IteratorAggregate{
    private array $categoryCollection;
	function __construct() {
        $this->categoryCollection = array();
	}
    function getLastItem():CategoryInterface{
        $lastItem = count($this->categoryCollection) - 1;
        return $this->categoryCollection[$lastItem];
    }
    function getItems():array{
        return $this->categoryCollection;
    }
    function add(CategoryInterface $category):void{
        $this->categoryCollection[] = $category;
    }
	function getIterator():Iterator {
        return new ArrayIterator($this->categoryCollection);
    }
}