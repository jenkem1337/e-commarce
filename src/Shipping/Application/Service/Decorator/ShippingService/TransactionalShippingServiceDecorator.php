<?php

class TransactionalShippingServiceDecorator extends ShippingServiceDecorator {
    private TransactionalRepository $transactionalRepository;
    function __construct(ShippingService $service, TransactionalRepository $transactionalRepository)
    {
        parent::__construct($service);
        $this->transactionalRepository = $transactionalRepository;
    }

    function findAll(FindAllShippingMethodDto $dto): ResponseViewModel
    {
            $response = parent::findAll($dto);
            
            return $response;
    }
    function findOneByUuid(FindOneShippingMethodDto $dto): ResponseViewModel
    {
            $response = parent::findOneByUuid($dto);

            return  $response;
    }
}