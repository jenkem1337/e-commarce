<?php

class FindAllProductWithPaginationDto {
    protected $perPageForProduct;

    protected $pageNum;

    protected $startingLimit;

    public function __construct($perPageForProduct, $pageNum)
    {
        $this->perPageForProduct = $perPageForProduct;
        $this->pageNum = $pageNum;
        $this->startingLimit = ($this->pageNum-1)*$this->perPageForProduct;
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

}