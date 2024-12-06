<?php

class IncrementStockQuantityForCanceledOrderDto {
    private array $productUuids;
    private array $orterItemsProductUuidReverseIndex;

    function __construct(OrderItemCollection $orderItems){
        $this->productUuids = [];
        $this->orterItemsProductUuidReverseIndex = [];
        foreach($orderItems->getItems() as $orderItem) {
            $this->productUuids[] = $orderItem->getProductUuid();
            $this->orterItemsProductUuidReverseIndex[$orderItem->getProductUuid()] = $orderItem;
        }
    }

    
    public function getProductUuids(): array
    {
        return $this->productUuids;
    }

    public function getOrterItemsProductUuidReverseIndex()
    {
        return $this->orterItemsProductUuidReverseIndex;
    }

}