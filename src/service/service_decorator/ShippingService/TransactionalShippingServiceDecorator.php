<?php

class TransactionalShippingServiceDecorator extends ShippingServiceDecorator {
    function __construct(ShippingService $service, DatabaseConnection $dbConnection)
    {
        parent::__construct($service);
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