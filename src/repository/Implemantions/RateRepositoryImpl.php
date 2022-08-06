<?php
require './vendor/autoload.php';

class RateRepositoryImpl implements RateRepository {
    private RateDao $rateDao;
    private RateFactory $rateFactory;
    function __construct(RateDao $rateDao, Factory $factory)
    {
        $this->rateDao = $rateDao;
        $this->rateFactory = $factory;
    }

    function persist(Rate $r)
    {
        $this->rateDao->persist($r);
    }
    function updateRateNumberByUuid(Rate $r)
    {
        $this->rateDao->updateRateNumberByUuid($r);
    }
    function deleteRateByUuid($uuid)
    {
        $this->rateDao->deleteRateByUuid($uuid);
    }
    function findAll(): RateCollection
    {
        $rateArray = new RateCollection();
        $rateObjects = $this->rateDao->findAll();
        foreach($rateObjects as $rateObject){
            $rateDomainObject = $this->rateFactory->createInstance(
                false,
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
        $rateDomainObject = $this->rateFactory->createInstance(
            false,
            $rateObject->uuid,
            $rateObject->product_uuid,
            $rateObject->user_uuid,
            $rateObject->created_at,
            $rateObject->updated_at
        );
        $rateDomainObject->rateIt($rateObject->rate_num);
        return $rateDomainObject;

    }
    function findAllByProductUuid($pUuid): IteratorAggregate
    {
        $rateArray = new RateCollection();
        $rateObjects = $this->rateDao->findAllByProductUuid($pUuid);
        foreach($rateObjects as $rateObject){
            $rateDomainObject = $this->rateFactory->createInstance(
                false,
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
    function setProductMediator(AbstractProductRepositoryMediatorComponent $mediator)
    {
        $mediator->setRateRepository($this);
    }
}