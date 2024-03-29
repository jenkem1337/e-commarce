<?php

class UserCollection implements IteratorAggregate{
    private array $userCollection;
	function __construct() {
        $this->userCollection = array();
	}
    function getItem($key):UserInterface{
        return $this->userCollection[(string)$key];
    }
    function getItems():array{
        return $this->userCollection;
    }
    function add(UserInterface $user):void{
        $this->userCollection[(string)$user->getUuid()] = $user;
    }
	function getIterator():Iterator {
        return new ArrayIterator($this->userCollection);
    }
}