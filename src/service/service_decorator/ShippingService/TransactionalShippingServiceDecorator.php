<?php

class TransactionalShippingServiceDecorator extends ShippingServiceDecorator {
    private DatabaseConnection $dbConnection;
    function __construct(ShippingService $service, DatabaseConnection $dbConnection)
    {
        $this->dbConnection = $dbConnection;
        parent::__construct($service);
    }

    function findAll(FindAllShippingMethodDto $dto): ResponseViewModel
    {
            $response = parent::findAll($dto);
            
            $this->dbConnection->closeConnection();
            return $response;
    }
    function findOneByUuid(FindOneShippingMethodDto $dto): ResponseViewModel
    {
            $response = parent::findOneByUuid($dto);
            

            $this->dbConnection->closeConnection();

            return  $response;
    }
}