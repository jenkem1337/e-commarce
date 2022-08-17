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
        try {
            $dbConnection = $this->dbConnection->getConnection();
            
            $dbConnection->beginTransaction();
            $response = parent::findAll($dto);
            
            $dbConnection->commit();

        } catch (Exception $e) {
            $dbConnection->rollBack();
            $response = new ErrorResponseDto($e->getMessage(), $e->getCode());
        } finally {
            $dbConnection = null;
            return $response;
        }

    }
    function findOneByUuid(FindOneShippingMethodDto $dto): ResponseViewModel
    {
        try {
            $dbConnection = $this->dbConnection->getConnection();
            
            $dbConnection->beginTransaction();
            $response = parent::findOneByUuid($dto);
            
            $dbConnection->commit();

        } catch (Exception $e) {
            $dbConnection->rollBack();
            $response = new ErrorResponseDto($e->getMessage(), $e->getCode());
        } finally {
            $dbConnection = null;
            return $response;
        }

    }
}