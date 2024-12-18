<?php

class RateRepositoryImpl implements RateRepository {
    private RateDao $rateDao;
    function __construct(RateDao $rateDao)
    {
        $this->rateDao = $rateDao;
    }

    function deleteRateByUuid($uuid)
    {
        $this->rateDao->deleteRateByUuid($uuid);
    }
    function deleteAllByProductUuid($productUuid){
        $this->rateDao->deleteAllByProductUuid($productUuid);
    }
    function findAll(): RateCollection
    {
        $rateArray = new RateCollection();
        $rateObjects = $this->rateDao->findAll();
        foreach($rateObjects as $rateObject){
            $rateDomainObject = Rate::newInstance(
                
                $rateObject->uuid,
                $rateObject->product_uuid,
                $rateObject->user_uuid,
                $rateObject->created_at,
                $rateObject->updated_at
            );
            $rateDomainObject->rateIt($rateObject->rate_num);
            $rateArray->add($rateDomainObject);
        }
        return $rateArray;
    }
    function findOneByUuid($uuid): RateInterface
    {
        $rateObject = $this->rateDao->findOneByUuid($uuid);
        $rateDomainObject = Rate::newInstance(
            
            $rateObject->uuid,
            $rateObject->product_uuid,
            $rateObject->user_uuid,
            $rateObject->created_at,
            $rateObject->updated_at
        );
        $rateDomainObject->rateIt($rateObject->rate_num);
        return $rateDomainObject;

    }
    function findAllByProductUuid($productUuid){
        $rateObjects = $this->rateDao->findAllByProductUuid($productUuid);
        return $rateObjects;
    }
    function findAllByProductAggregateUuid($pUuid): IteratorAggregate
    {
        $rateArray = new RateCollection();
        $rateObjects = $this->rateDao->findAllByProductUuid($pUuid);
        foreach($rateObjects as $rateObject){
            $rateDomainObject = Rate::newInstance(
                
                $rateObject->uuid,
                $rateObject->product_uuid,
                $rateObject->user_uuid,
                $rateObject->created_at,
                $rateObject->updated_at
            );
            $rateDomainObject->rateIt($rateObject->rate_num);
            if(!$rateDomainObject->isNull()){
                $rateArray->add($rateDomainObject);
            }
        }
        return $rateArray;

    }
    function findOneByProductUuidAndUserUuid($productUuid, $userUuid): RateInterface{
        $rateObject = $this->rateDao->findOneByProductUuidAndUserUuid($productUuid, $userUuid);
        return Rate::newInstance(
            $rateObject->uuid,
            $rateObject->product_uuid,
            $rateObject->user_uuid,
            $rateObject->created_at,
            $rateObject->updated_at
        );
    }
}