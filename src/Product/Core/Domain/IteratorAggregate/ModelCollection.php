<?php

class ModelCollection implements IteratorAggregate {
    private array $modelCollection;
    function __construct()
    {
        $this->modelCollection = array();
    }
    function getItems():array{
        return $this->modelCollection;
    }
    function clearItems(){
        $this->modelCollection = array();
    }
    function getItem($key):ModelInterface{
        return $this->modelCollection[(string)$key] ?? new NullModel();
    }
    function add(Model $model):void{
        $this->modelCollection[(string)$model->getUuid()] = $model; 
    }
    function getIterator(): Iterator
    {
        return new ArrayIterator($this->modelCollection);
    }

}