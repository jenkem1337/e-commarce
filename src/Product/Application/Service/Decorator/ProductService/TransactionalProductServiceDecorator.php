<?php

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
            return $response;
        } catch (Exception $e) {
            $dbConnection->rollBack();
            throw $e;
        } 
    }
    function findProductsByCriteria(FindProductsByCriteriaDto $dto): ResponseViewModel
    {
            $response = parent::findProductsByCriteria($dto);
            return $response;
    }

    function findProductBySearch(FindProductsBySearchDto $dto): ResponseViewModel
    {
            $response = parent::findProductsBySearch($dto);
            return $response;

    }
    function createNewProductSubscriber(ProductSubscriberCreationalDto $dto): ResponseViewModel
    {
        try {
            $dbConnection = $this->dbConnection->getConnection();
            
            $dbConnection->beginTransaction();
            $response = parent::createNewProductSubscriber($dto);
            
            $dbConnection->commit();
            return $response;
        } catch (Exception $e) {
            $dbConnection->rollBack();
            throw $e;
        } 

    }

    function updateProductStockQuantity(ChangeProductStockQuantityDto $dto): ResponseViewModel
    {
        try {
            $dbConnection = $this->dbConnection->getConnection();
            
            $dbConnection->beginTransaction();
            $response = parent::updateProductStockQuantity($dto);
            
            $dbConnection->commit();
            return $response;
        } catch (Exception $e) {
            $dbConnection->rollBack();
            throw $e;
        } 

    }
    function deleteProduct(DeleteProductByUuidDto $dto): ResponseViewModel
    {
        try {
            $dbConnection = $this->dbConnection->getConnection();
            
            $dbConnection->beginTransaction();
            $response = parent::deleteProduct($dto);
            
            $dbConnection->commit();
            return $response;
        } catch (Exception $e) {
            $dbConnection->rollBack();
            throw $e;
        } 

    }

    function deleteProductSubscriber(DeleteProductSubscriberDto $dto): ResponseViewModel
    {
        try {
            $dbConnection = $this->dbConnection->getConnection();
            
            $dbConnection->beginTransaction();
            $response = parent::deleteProductSubscriber($dto);
            
            $dbConnection->commit();
            return $response;

        } catch (Exception $e) {
            $dbConnection->rollBack();
            throw $e;
        } 

    }
    
    function findOneProductByUuid(FindOneProductByUuidDto $dto): ResponseViewModel
    {
        try {
            $response = parent::findOneProductByUuid($dto);
            return $response;

        } catch (\Exception $th) {
            throw $th;
        }


    }
    
    function updateProductDetailsByUuid(ProductDetailDto $dto): ResponseViewModel {
        try {
            $dbConnection = $this->dbConnection->getConnection();
            
            $dbConnection->beginTransaction();
            $response = parent::updateProductDetailsByUuid($dto);
            
            $dbConnection->commit();
            return $response;
        } catch (Exception $e) {
            $dbConnection->rollBack();
            throw $e;
        } 
    }

    
}