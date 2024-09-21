<?php
class FindProductsByCriteriaDto {
    private $spesificCategories;
    private $priceLowerBound;
    private $priceUpperBound;
    private $rateLowerBound;
    private $rateUpperBound;
    private $perPageForProduct;
    private $pageNum;
    private $startingLimit;
    private $filters;

    public function __construct($speificCategories, $priceLowerBound, $priceUpperBound, $rateLowerBound, $rateUpperBound, $perPageForProduct, $pageNum, $filter)
    {
        if(($priceLowerBound < 0) || ($priceUpperBound < 0)) {
            throw new NegativeValueException();
        }
        
        $this->spesificCategories = $speificCategories;
        $this->priceLowerBound = $priceLowerBound;
        $this->priceUpperBound = $priceUpperBound;
        $this->rateLowerBound = $rateLowerBound;
        $this->rateUpperBound = $rateUpperBound;
        $this->perPageForProduct = $perPageForProduct;
        $this->startingLimit = ($pageNum-1)*$this->perPageForProduct;
        $this->filters = $filter;    

    }

    /**
     * Get the value of filters
     */ 
    public function getFilters()
    {
        return $this->filters;
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
     * Get the value of perPageForProduct
     */ 
    public function getPerPageForProduct()
    {
        return $this->perPageForProduct;
    }

    /**
     * Get the value of rateUpperBound
     */ 
    public function getRateUpperBound()
    {
        return $this->rateUpperBound;
    }

    /**
     * Get the value of rateLowerBound
     */ 
    public function getRateLowerBound()
    {
        return $this->rateLowerBound;
    }

    /**
     * Get the value of priceUpperBound
     */ 
    public function getPriceUpperBound()
    {
        return $this->priceUpperBound;
    }

    /**
     * Get the value of priceLowerBound
     */ 
    public function getPriceLowerBound()
    {
        return $this->priceLowerBound;
    }

    /**
     * Get the value of spesificCategories
     */ 
    public function getSpesificCategories()
    {
        return $this->spesificCategories;
    }
}