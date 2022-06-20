<?php
require "./vendor/autoload.php";

class UserCollection implements IteratorAggregate{
    private array $userCollection;
	function __construct() {
        $this->userCollection = array();
	}
    function getLastItem():UserInterface{
        $lastItem = count($this->userCollection) - 1;
        return $this->userCollection[$lastItem];
    }
    function getItems(){
        return $this->userCollection;
    }
    function add(UserInterface $user){
        $this->userCollection[] = $user;
    }
	function getIterator():Iterator {
        return new ArrayIterator($this->userCollection);
    }
}