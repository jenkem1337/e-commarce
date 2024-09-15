<?php

class ShippingRepositoryImpl implements ShippingRepository {
    private ShippingDao $shippingDao;
    private ShippingFactoryContext $shippingFactoryContext;
    
	/**
	 * @param $shippingDao ShippingDao 
	 * @param $shippingFactoryContext ShippingFactoryContext 
	 */
	function __construct(ShippingDao $shippingDao, ShippingFactoryContext $shippingFactoryContext) {
	    $this->shippingDao = $shippingDao;
	    $this->shippingFactoryContext = $shippingFactoryContext;
	}
	/**
	 *
	 * @return IteratorAggregate
	 */
	function findAll(): IteratorAggregate {
        $shippingCollection = new ShippingCollection;
        $shippingObj = $this->shippingDao->findAll();
        foreach($shippingObj as $shipping){
            $shippingDomainObject = $this->shippingFactoryContext->executeFactory(
                $shipping->shipping_type,
                false,
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

        $shippingDomainObject = $this->shippingFactoryContext->executeFactory(
            $shippingObj->shipping_type,
            false,
            $shippingObj->shipping_type,
            $shippingObj->uuid,
            $shippingObj->price,
            $shippingObj->created_at,
            $shippingObj->updated_at
        );
        return $shippingDomainObject;
    }
}