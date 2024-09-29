<?php

class TransactionalImageServiceDecorator extends ImageServiceDecorator {
    private DatabaseConnection $dbConnection;
    function __construct(ImageService $imgService, DatabaseConnection $dbconn)
    {
        $this->dbConnection = $dbconn;
        parent::__construct($imgService);
    }
    function uploadImageForProduct(ImageCreationalDto $dto): ResponseViewModel
    {
        try {
            $dbConnection = $this->dbConnection->getConnection();
            
            $dbConnection->beginTransaction();
            $response = parent::uploadImageForProduct($dto);
            
            $dbConnection->commit();
            return $response;

        } catch (Exception $e) {
            $dbConnection->rollBack();
            throw $e;
        } 
    }
    function deleteImageByUuid(DeleteImageByUuidDto $dto):ResponseViewModel{
        try {
            $dbConnection = $this->dbConnection->getConnection();
            
            $dbConnection->beginTransaction();
            $response = parent::deleteImageByUuid($dto);
            
            $dbConnection->commit();
            return $response;

        } catch (Exception $e) {
            $dbConnection->rollBack();
            throw $e;

        } 

    }

}