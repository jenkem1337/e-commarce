<?php

class AllShippingMethodsResponseDto extends ResponseViewModel implements JsonSerializable{
    protected IteratorAggregate $shippings;

    public function __construct(IteratorAggregate $shippings)
    {
        $this->shippings = $shippings;
        parent::__construct('success', $this);
    }

    

    /**
     * Get the value of shippings
     */ 
    public function getShippings():IteratorAggregate
    {
        return $this->shippings;
    }

    function jsonSerialize(): mixed
    {
        $response = [];
        foreach($this->getShippings() as $shipping){
            $response[] = [
                            'uuid'=>$shipping->getUuid(),
                            'shipping_type' => $shipping->getShippingType(),
                            'price' => $shipping->getPrice(),
                            'created_at'=>$shipping->getCreatedAt(),
                            'updated_at'=> $shipping->getUpdatedAt()
                          ];
        }
        return $response;
    }
}