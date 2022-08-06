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
    function uploadImageForProduct(ImageCreationalDto $dto): ResponseViewModel
    {
        try {
            $dbConnection = $this->dbConnection->getConnection();
            
            $dbConnection->beginTransaction();
            $response = parent::uploadImageForProduct($dto);
            
            $dbConnection->commit();

        } catch (Exception $e) {
            $dbConnection->rollBack();
            $response = new ErrorResponseDto($e->getMessage(), $e->getCode());
        } finally {
            $dbConnection = null;
            return $response;
        }

    }
    function createNewCategory(CategoryCreationalDto $dto): ResponseViewModel
    {
        try {
            $dbConnection = $this->dbConnection->getConnection();
            
            $dbConnection->beginTransaction();
            $response = parent::createNewCategory($dto);
            
            $dbConnection->commit();

        } catch (Exception $e) {
            $dbConnection->rollBack();
            $response = new ErrorResponseDto($e->getMessage(), $e->getCode());
        } finally {
            $dbConnection = null;
            return $response;
        }

    }
    function findOneCategoryByUuid(FindCategoryByUuidDto $dto): ResponseViewModel
    {
        try {
            $dbConnection = $this->dbConnection->getConnection();
            
            $dbConnection->beginTransaction();
            $response = parent::findOneCategoryByUuid($dto);
            
            $dbConnection->commit();

        } catch (Exception $e) {
            $dbConnection->rollBack();
            $response = new ErrorResponseDto($e->getMessage(), $e->getCode());
        } finally {
            $dbConnection = null;
            return $response;
        }

    }
    function updateCategoryNameByUuid(UpdateCategoryNameByUuidDto $dto): ResponseViewModel
    {
        try {
            $dbConnection = $this->dbConnection->getConnection();
            
            $dbConnection->beginTransaction();
            $response = parent::updateCategoryNameByUuid($dto);
            
            $dbConnection->commit();

        } catch (Exception $e) {
            $dbConnection->rollBack();
            $response = new ErrorResponseDto($e->getMessage(), $e->getCode());
        } finally {
            $dbConnection = null;
            return $response;
        }
    }
    function deleteCategoryByUuid(DeleteCategoryDto $dto): ResponseViewModel
    {
        try {
            $dbConnection = $this->dbConnection->getConnection();
            
            $dbConnection->beginTransaction();
            $response = parent::deleteCategoryByUuid($dto);
            
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