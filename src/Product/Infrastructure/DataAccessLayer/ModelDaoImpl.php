<?php

class ModelDaoImpl implements ModelDao {
    private DatabaseConnection $databaseInterface;
    function __construct($databaseInterface) {
        $this->databaseInterface = $databaseInterface;
    }

    function findAllByBrandUuid($uuid){
        $conn = $this->databaseInterface->getConnection();
        $stmt = $conn->prepare("SELECT * FROM brand_models WHERE brand_uuid = :brand_uuid");
        $stmt->execute([
            'brand_uuid'=>$uuid
        ]);
        $models = $stmt->fetchAll(PDO::FETCH_OBJ);
        $conn = null; 
        if($models == null) return $this->returnNullModels();
        return $models;

    }
    function findOneByUuid($uuid){
        $conn = $this->databaseInterface->getConnection();
        $stmt = $conn->prepare("SELECT * FROM brand_models WHERE uuid = :uuid LIMIT 1");
        $stmt->execute([
            'uuid'=>$uuid
        ]);
        $model = $stmt->fetch(PDO::FETCH_OBJ);
        $conn = null; 
        if($model == null) return $this->returnNullModel();
        return $model;


    }

    function deleteByBrandUuid($brandUuid){
        $conn = $this->databaseInterface->getConnection();
        $stmt = $conn->prepare("DELETE FROM brand_models WHERE brand_uuid = :brand_uuid");
        $stmt->execute([
            "brand_uuid" => $brandUuid
        ]);
        $conn = null; 
    }
    private function returnNullModels() {
        $model = new stdClass();
        $model->uuid = null;
        return [$model];
    } 
    private function returnNullModel() {
        $model = new stdClass();
        $model->uuid = null;
        return $model;

    }
}