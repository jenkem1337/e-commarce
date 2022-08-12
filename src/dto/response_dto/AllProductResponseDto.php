<?php
class AllProductResponseDto extends ResponseViewModel {
    protected IteratorAggregate $products;

    public function __construct(IteratorAggregate $products)
    {
        $this->products = $products;
        parent::__construct('success', $this);
    }

    /**
     * Get the value of products
     */ 
    public function getProducts(): IteratorAggregate
    {
        return $this->products;
    }
}