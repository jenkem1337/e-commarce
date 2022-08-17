<?php 
class SearchedProductResponseDto extends ResponseViewModel {
    protected IteratorAggregate $products;


    protected IteratorAggregate $shippings;

    public function __construct(IteratorAggregate $products, IteratorAggregate $shippings)
    {
        $this->products = $products;
        $this->shippings = $shippings;
        parent::__construct('success', $this);

    }

    /**
     * Get the value of products
     */ 
    public function getProducts(): IteratorAggregate
    {
        return $this->products;
    }

    /**
     * Get the value of shippings
     */ 
    public function getShippings():IteratorAggregate
    {
        return $this->shippings;
    }
}