<?php

class DeleteProductSubscriberDto {
    protected $productUuid;

    protected $subscriberUuid;

    public function __construct($productUuid, $subscriberUuid)
    {
        $this->productUuid = $productUuid;
        $this->subscriberUuid = $subscriberUuid;
    }

    /**
     * Get the value of subscriberUuid
     */ 
    public function getSubscriberUuid()
    {
        return $this->subscriberUuid;
    }

    /**
     * Get the value of productUuid
     */ 
    public function getProductUuid()
    {
        return $this->productUuid;
    }
}