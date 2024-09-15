<?php

class FindProductsByPriceRangeDto {
    protected $from;

    protected $to;
    protected $filter;

    public function __construct($from, $to, $filter) 
    {
        $this->from = $from;
        $this->to = $to;
        $this->filter = $filter;
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

    /**
     * Get the value of filter
     */ 
    public function getFilter()
    {
        return $this->filter;
    }
}