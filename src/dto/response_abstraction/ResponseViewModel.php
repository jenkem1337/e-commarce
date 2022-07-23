<?php

abstract class ResponseViewModel {
    private ArrayIterator $arrayIterator;
    private array $arr;
    function __construct($event, $responseDtoObject)
    {
        $this->arr = array($event => $responseDtoObject);
        $this->arrayIterator = new ArrayIterator($this->arr);
    }

    function onSucsess($callback):ResponseViewModel{
        if(!is_callable($callback)) throw new Exception('it should be function');
        if(!($this->arrayIterator->key() == 'success')) return $this;
        $callback($this->arrayIterator->current());
        return $this;
    }
    function onError($callback):void{
        if(!is_callable($callback)) throw new Exception('it should be function');
        if(!($this->arrayIterator->key() == 'error')) return;
        $callback($this->arrayIterator->current());
    }


}