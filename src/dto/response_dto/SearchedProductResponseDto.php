<?php 
class SearchedProductResponseDto extends ResponseViewModel {
    protected IteratorAggregate $products;

    public function __construct(IteratorAggregate $products)
    {
        $this->products = $products;
        parent::__construct('success', $this);
    }

    

    /**
     * Get the value of products
     */ 
    public function getProducts()
    {
        return $this->products;
    }
}