<?php

class ShippingRepositoryImpl extends TransactionalRepository implements ShippingRepository {
    private ShippingDao $shippingDao;
    
	function __construct(ShippingDao $shippingDao) {
	    $this->shippingDao = $shippingDao;
        parent::__construct($this->shippingDao);
	}
	function saveChanges(Shipping $shipping){
        $this->shippingDao->saveChanges($shipping);
    }
    function findAll() {
        return $this->shippingDao->findAll();
	}
    function findOneByUuid($uuid): ShippingInterface
    {
        $shippingObj = $this->shippingDao->findOneByUuid($uuid);
        
        $shippingDomainObject = Shipping::newInstance(
            $shippingObj->uuid,
            Type::fromValue($shippingObj->type),
            ShippingStatusFactory::fromValue($shippingObj->status),
            $shippingObj->address_title,
            $shippingObj->address_owner_name,
            $shippingObj->address_owner_surname,
            $shippingObj->full_address,
            $shippingObj->address_country,
            $shippingObj->address_province,
            $shippingObj->address_district,
            $shippingObj->address_zipcode,
            $shippingObj->created_at,
            $shippingObj->updated_at
        );
        return $shippingDomainObject;
    }
}