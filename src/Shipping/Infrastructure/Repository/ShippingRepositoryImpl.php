<?php

class ShippingRepositoryImpl implements ShippingRepository {
    private ShippingDao $shippingDao;
    
	function __construct(ShippingDao $shippingDao) {
	    $this->shippingDao = $shippingDao;
	}
	
    function findAll(): IteratorAggregate {
        $shippingCollection = new ShippingCollection;
        $shippingObj = $this->shippingDao->findAll();
        foreach($shippingObj as $shipping){
            $shippingDomainObject = Shipping::newInstance(
                $shipping->shipping_type,
                $shipping->uuid,
                $shipping->price,
                $shipping->created_at,
                $shipping->updated_at
            );
            $shippingCollection->add($shippingDomainObject);
        }
        return $shippingCollection; 
	}
    function findOneByUuid($uuid): ShippingInterface
    {
        $shippingObj = $this->shippingDao->findOneByUuid($uuid);

        $shippingDomainObject = Shipping::newInstance(
            $shippingObj->shipping_type,
            $shippingObj->uuid,
            $shippingObj->price,
            $shippingObj->created_at,
            $shippingObj->updated_at
        );
        return $shippingDomainObject;
    }
}