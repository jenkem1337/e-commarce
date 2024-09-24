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
            return $response;
        } catch (Exception $e) {
            $dbConnection->rollBack();
            throw $e;
        } 

    }
    function findOneCategoryByUuid(FindCategoryByUuidDto $dto): ResponseViewModel
    {
            return parent::findOneCategoryByUuid($dto);
    }
    function updateCategoryNameByUuid(UpdateCategoryNameByUuidDto $dto): ResponseViewModel
    {
        try {
            $dbConnection = $this->dbConnection->getConnection();
            
            $dbConnection->beginTransaction();
            $response = parent::updateCategoryNameByUuid($dto);
            
            $dbConnection->commit();
            return $response;

        } catch (Exception $e) {
            $dbConnection->rollBack();
            throw $e;
        } 
    }
    function deleteCategoryByUuid(DeleteCategoryDto $dto): ResponseViewModel
    {
        try {
            $dbConnection = $this->dbConnection->getConnection();
            
            $dbConnection->beginTransaction();
            $response = parent::deleteCategoryByUuid($dto);
            
            $dbConnection->commit();
            return $response;

        } catch (Exception $e) {
            $dbConnection->rollBack();
            throw $e;
        } 

    }

}