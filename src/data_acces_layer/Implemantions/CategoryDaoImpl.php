<?php

require './vendor/autoload.php';

class CategoryDaoImpl implements CategoryDao {
    protected DatabaseConnection $databaseConnection;
	function __construct(DatabaseConnection $databaseConnection) {
        $this->databaseConnection = $databaseConnection;
	}
	function persist(Category $c) {
        $conn = $this->databaseConnection->getConnection();
        $stmt = $conn->prepare("INSERT INTO category (uuid, category_name, created_at, updated_at) VALUES (:uuid, :category_name, :created_at, :updated_at)");
        $stmt->execute([
            'uuid'=>$c->getUuid(),
            'category_name' => $c->getCategoryName(),
            'created_at'=> $c->getCreatedAt(),
            'updated_at'=>$c->getUpdatedAt() 
        ]);
        $conn = null;
    }
	
	function deleteByUuid($uuid) {
        $conn = $this->databaseConnection->getConnection();
        $stmt = $conn->prepare("DELETE FROM category WHERE uuid = :uuid");
        $stmt->execute([
            'uuid'=> $uuid
        ]); 
       $conn = null; 
	}
	
	function findByUuid($uuid) {
        $conn = $this->databaseConnection->getConnection();
        $stmt = $conn->prepare("SELECT * FROM category WHERE uuid = :uuid LIMIT 1");
        $stmt->execute([
            'uuid'=>$uuid
        ]);
        $category = $stmt->fetch(PDO::FETCH_OBJ);
        $conn = null; 
        if($category == null) return $this->returnNullStatment();
        return $category;
	}
	
	function updateNameByUuid($uuid, $newCategoryName) {
        $conn = $this->databaseConnection->getConnection();
        $stmt = $conn->prepare("UPDATE category SET category_name = :category_name WHERE uuid = :uuid");
        $stmt->execute([
             'category_name'=>$newCategoryName,
             'uuid'=> $uuid
        ]);
        $conn = null;
	}
	
	function findAll() {
        $conn = $this->databaseConnection->getConnection();
        $stmt = $conn->prepare("SELECT * FROM category");
        $stmt->execute();
        $categories = $stmt->fetchAll(PDO::FETCH_OBJ);
        $conn = null;
        if($categories == null) return $this->returnNullStatment();
        return $categories;
	}
	
	function addCategoryUuidToProduct($productUuid) {
	}
    private function returnNullStatment() {
        $arr = [

            'uuid'=>null,
            'category_name' => null,
            'created_at'=>null,
            'updated_at'=>null,
        ];
        return json_decode(json_encode($arr),false);
    } 

}