<?php
require './vendor/autoload.php';

class TransactionalProductServiceDecorator extends ProductServiceDecorator {
    private DatabaseConnection $dbConnection;
    function __construct(ProductService $productService, DatabaseConnection $dbConnection)
    {
        $this->dbConnection = $dbConnection;
        parent::__construct($productService);
    }
    function craeteNewProduct(ProductCreationalDto $dto): ResponseViewModel
    {
        try {
            $dbConnection = $this->dbConnection->getConnection();
            
            $dbConnection->beginTransaction();
            $response = parent::craeteNewProduct($dto);
            
            $dbConnection->commit();

        } catch (Exception $e) {
            $dbConnection->rollBack();
            $response = new ErrorResponseDto($e->getMessage(), $e->getCode());
        } finally {
            $dbConnection = null;
            return $response;
        }
    }
    function updateProductBrandName(ChangeProductBrandNameDto $dto): ResponseViewModel
    {
        try {
            $dbConnection = $this->dbConnection->getConnection();
            
            $dbConnection->beginTransaction();
            $response = parent::updateProductBrandName($dto);
            
            $dbConnection->commit();

        } catch (Exception $e) {
            $dbConnection->rollBack();
            $response = new ErrorResponseDto($e->getMessage(), $e->getCode());
        } finally {
            $dbConnection = null;
            return $response;
        }

    }
    function findOneProductByUuid(FindOneProductByUuidDto $dto): ResponseViewModel
    {
        try {
            $dbConnection = $this->dbConnection->getConnection();
            
            $dbConnection->beginTransaction();
            $response = parent::findOneProductByUuid($dto);
            
            $dbConnection->commit();

        } catch (Exception $e) {
            $dbConnection->rollBack();
            $response = new ErrorResponseDto($e->getMessage(), $e->getCode());
        } finally {
            $dbConnection = null;
            return $response;
        }

    }
    function updateProductModelName(ChangeProductModelNameDto $dto): ResponseViewModel
    {
        try {
            $dbConnection = $this->dbConnection->getConnection();
            
            $dbConnection->beginTransaction();
            $response = parent::updateProductModelName($dto);
            
            $dbConnection->commit();

        } catch (Exception $e) {
            $dbConnection->rollBack();
            $response = new ErrorResponseDto($e->getMessage(), $e->getCode());
        } finally {
            $dbConnection = null;
            return $response;
        }

    }
    function updateProductHeader(ChangeProductHeaderDto $dto): ResponseViewModel
    {
        try {
            $dbConnection = $this->dbConnection->getConnection();
            
            $dbConnection->beginTransaction();
            $response = parent::updateProductHeader($dto);
            
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