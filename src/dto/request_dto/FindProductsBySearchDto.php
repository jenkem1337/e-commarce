<?php
class FindProductsBySearchDto {
    protected $searchValue;
    protected $perPageForProduct;
    protected $startingLimit;


    public function __construct($searchValue, $perPageForProduct, $pageNum)
    {
        $this->searchValue = $searchValue;
        $this->perPageForProduct = $perPageForProduct;
        $this->startingLimit = ($pageNum-1)*$this->perPageForProduct;

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
}