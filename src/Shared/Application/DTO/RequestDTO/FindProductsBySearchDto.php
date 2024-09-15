<?php
class FindProductsBySearchDto {
    protected $searchValue;
    protected $perPageForProduct;
    protected $startingLimit;
    protected $filter;


    public function __construct($searchValue, $perPageForProduct, $pageNum, $filter)
    {
        $this->searchValue = $searchValue;
        $this->perPageForProduct = $perPageForProduct;
        $this->startingLimit = ($pageNum-1)*$this->perPageForProduct;
        $this->filter = $filter;    

    }



    /**
     * Get the value of perPageForProduct
     */ 
    public function getPerPageForProduct()
    {
        return $this->perPageForProduct;
    }

    /**
     * Get the value of startingLimit
     */ 
    public function getStartingLimit()
    {
        return $this->startingLimit;
    }

    /**
     * Get the value of searchValue
     */ 
    public function getSearchValue()
    {
        return $this->searchValue;
    }

    /**
     * Get the value of filter
     */ 
    public function getFilter()
    {
        return $this->filter;
    }
}