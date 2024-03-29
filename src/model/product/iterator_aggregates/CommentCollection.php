<?php

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
        return $this->commentCollection[(string)$key] ?? new NullComment();
    }
    function clearItems(){
        $this->commentCollection = array();
    }

    function add(CommentInterface $comment):void{
        $this->commentCollection[(string)$comment->getUuid()] = $comment; 
    }
    function getIterator(): Iterator
    {
        return new ArrayIterator($this->commentCollection);
    }
}