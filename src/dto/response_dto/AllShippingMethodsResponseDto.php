<?php

class AllShippingMethodsResponseDto extends ResponseViewModel {
    protected IteratorAggregate $shippings;

    public function __construct(IteratorAggregate $shippings)
    {
        $this->shippings = $shippings;
        parent::__construct('success', $this);
    }

    

    /**
     * Get the value of shippings
     */ 
    public function getShippings():IteratorAggregate
    {
        return $this->shippings;
    }
}