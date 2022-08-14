<?php

class FindProductsByPriceRangeDto {
    protected $from;

    protected $to;

    public function __construct($from, $to)
    {
        $this->from = $from;
        $this->to = $to;
    }



    /**
     * Get the value of from
     */ 
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * Get the value of to
     */ 
    public function getTo()
    {
        return $this->to;
    }
}