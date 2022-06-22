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
    function getItem($key):CommentInterface{
        return $this->commentCollection[$key];
    }
    function add(CommentInterface $comment):void{
        $this->commentCollection[$comment->getUuid()] = $comment; 
    }
    function getIterator(): Iterator
    {
        return new ArrayIterator($this->commentCollection);
    }
}