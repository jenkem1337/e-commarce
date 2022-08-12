<?php

class TransactionalCategoryServiceDecorator extends CategoryServiceDecorator {
    private DatabaseConnection $dbConnection;
    function __construct(CategoryService $service, DatabaseConnection $dbconn)
    {
        $this->dbConnection = $dbconn;
        parent::__construct($service);
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