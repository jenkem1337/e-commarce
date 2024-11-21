<?php

class OrderItem extends BaseEntity {
    private $productUuid;
    private $orderUuid;
    private $quantity;
    private function __construct($uuid, $orderUuid, $productUuid, $quantity, $createdAt, $updatedAt){
        parent::__construct($uuid, $createdAt, updatedAt: $updatedAt);
        $this->productUuid = $productUuid;
        $this->orderUuid = $orderUuid;
        $this->quantity = $quantity;
    }

    static function newStrictInsatance($uuid, $orderUuid, $productUuid, $quantity, $createdAt, $updatedAt): OrderItem {
        return new OrderItem($uuid, $orderUuid, $productUuid, $quantity, $createdAt, $updatedAt);
    }
    /**
     * Get the value of productUuid
     */ 
    public function getProductUuid()
    {
        return $this->productUuid;
    }

    /**
     * Get the value of orderUuid
     */ 
    public function getOrderUuid()
    {
        return $this->orderUuid;
    }

    /**
     * Get the value of quantity
     */ 
    public function getQuantity()
    {
        return $this->quantity;
    }
}