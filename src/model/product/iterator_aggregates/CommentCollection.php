<?php
require "./vendor/autoload.php";

class CommentCollection implements IteratorAggregate {
    private array $commentCollection;
    function __construct()
    {
        $this->commentCollection = array();
    }
    function getItems():array{
        return $this->commentCollection;
    }
    function getLastItem():CommentInterface{
        $lastItem = count($this->commentCollection) - 1;
        return $this->commentCollection[$lastItem];
    }
    function add(CommentInterface $comment):void{
        $this->commentCollection[] = $comment; 
    }
    function getIterator(): Iterator
    {
        return new ArrayIterator($this->commentCollection);
    }
}