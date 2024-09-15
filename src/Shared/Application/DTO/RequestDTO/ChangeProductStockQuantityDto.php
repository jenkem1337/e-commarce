<?php
class StockQuantityChangingConstant{
    const INCREMENT_QUANTITY = 'INCREMENT_QUANTITY';
    const DECREMENT_QUANTITY = 'DECREMENT_QUANTITY';
}
class ChangeProductStockQuantityDto {
    protected $productUuid;

    protected $updatingStrategy;


    protected $quantity;

    public function __construct($productUuid, $quantity, $updatingStrategy)
    {
        $this->productUuid = $productUuid;
        $this->updatingStrategy = $updatingStrategy;
        $this->quantity = $quantity;
    }



    /**
     * Get the value of productUuid
     */ 
    public function getProductUuid()
    {
        return $this->productUuid;
    }

    /**
     * Get the value of updatingStrategy
     */ 
    public function getUpdatingStrategy()
    {
        return $this->updatingStrategy;
    }

    /**
     * Get the value of quantity
     */ 
    public function getQuantity()
    {
        return $this->quantity;
    }
}