<?php

class BrandDaoImpl extends AbstractDataAccessObject implements BrandDao{
    private DatabaseConnection $databaseInterface;
    function __construct($databaseInterface) {
        $this->databaseInterface = $databaseInterface;
        parent::__construct($this->databaseInterface);
    }

    function findOneByUuid($uuid){
        $conn = $this->databaseInterface->getConnection();
        $stmt = $conn->prepare("SELECT * FROM brands WHERE uuid = :uuid LIMIT 1");
        $stmt->execute([
            'uuid'=>$uuid
        ]);
        $brand = $stmt->fetch(PDO::FETCH_OBJ);
        $conn = null; 
        if($brand == null) return $this->returnNullBrand();
        return $brand;

    }

    function findAll(){
        $conn = $this->databaseInterface->getConnection();
        $stmt = $conn->prepare("SELECT * FROM brands");
        $stmt->execute();
        $brands = $stmt->fetchAll(PDO::FETCH_OBJ);
        $conn = null; 
        if($brands == null) return $this->returnNullBrands();
        return $brands;
    }

    function deleteByUuid($uuid){
        $conn = $this->databaseInterface->getConnection();
        $stmt = $conn->prepare("DELETE FROM brands WHERE uuid = :uuid");
        $stmt->execute([
            "uuid" => $uuid
        ]);
        $conn = null; 
    }
    private function returnNullBrand() {
        $brand = new stdClass();
        $brand->uuid = null;
        return $brand;
    } 
    private function returnNullBrands() {
        $brand = new stdClass();
        $brand->uuid = null;
        return [$brand];
    } 


}