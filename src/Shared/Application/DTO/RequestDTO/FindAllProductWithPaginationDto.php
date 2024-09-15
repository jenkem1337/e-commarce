<?php

class FindAllProductWithPaginationDto {
    protected $perPageForProduct;

    protected $pageNum;

    protected $startingLimit;
    protected $filter;

    public function __construct($perPageForProduct, $pageNum, $filter)
    {
        $this->perPageForProduct = $perPageForProduct;
        $this->pageNum = $pageNum;
        $this->startingLimit = ($this->pageNum-1)*$this->perPageForProduct;
        $this->filter = $filter;
    }



    /**
     * Get the value of startingLimit
     */ 
    public function getStartingLimit()
    {
        return $this->startingLimit;
    }

    /**
     * Get the value of pageNum
     */ 
    public function getPageNum()
    {
        return $this->pageNum;
    }

    /**
     * Get the value of perPageForUser
     */ 
    public function getPerPageForProduct()
    {
        return $this->perPageForProduct;
    }


    /**
     * Get the value of filter
     */ 
    public function getFilter()
    {
        return $this->filter;
    }
}