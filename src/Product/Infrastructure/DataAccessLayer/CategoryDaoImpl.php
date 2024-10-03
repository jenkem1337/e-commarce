<?php

use Ramsey\Uuid\Uuid;
class CategoryDaoImpl extends AbstractDataAccessObject implements CategoryDao {
    protected DatabaseConnection $databaseConnection;
	function __construct(DatabaseConnection $databaseConnection) {
        $this->databaseConnection = $databaseConnection;
        parent::__construct($this->databaseConnection);

	}
	function persist(Category $c) {
        $conn = $this->databaseConnection->getConnection();
        $stmt = $conn->prepare(
            "INSERT INTO categories (uuid, category_name, created_at, updated_at) 
             VALUES (:uuid, :category_name, :created_at, :updated_at)"
        );
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
        $stmt = $conn->prepare("DELETE FROM categories WHERE uuid = :uuid");
        $stmt->execute([
            'uuid'=> $uuid
        ]); 
       $conn = null; 
	}
	
	function findByUuid($uuid) {
        $conn = $this->databaseConnection->getConnection();
        $stmt = $conn->prepare("SELECT * FROM categories WHERE uuid = :uuid LIMIT 1");
        $stmt->execute([
            'uuid'=>$uuid
        ]);
        $category = $stmt->fetch(PDO::FETCH_OBJ);
        $conn = null; 
        if($category == null) return $this->returnNullStatment();
        return $category;
	}

    function findASetOfByUuids($uuids) {
        $in = str_repeat('?,', count($uuids) - 1) . '?';
        
        $conn = $this->databaseConnection->getConnection();
        $stmt = $conn->prepare("SELECT * FROM categories WHERE uuid IN ($in)");
        $stmt->execute($uuids);
        $category = $stmt->fetchAll(PDO::FETCH_OBJ);
        $conn = null; 
        if($category == null) return $this->returnManyNullStatment();
        return $category;

    }
	
	function updateNameByUuid(Category $c) {
        $conn = $this->databaseConnection->getConnection();
        $stmt = $conn->prepare("UPDATE categories SET category_name = :category_name, updated_at=NOW() WHERE uuid = :uuid");
        $stmt->execute([
             'category_name'=>$c->getCategoryName(),
             'uuid'=> $c->getUuid()
        ]);
        $conn = null;
	}
	
	function findAll() {
        $conn = $this->databaseConnection->getConnection();
        $stmt = $conn->prepare("SELECT * FROM categories ORDER BY created_at DESC");
        $stmt->execute();
        $categories = $stmt->fetchAll(PDO::FETCH_OBJ);
        $conn = null;
        if($categories == null) return $this->returnManyNullStatment();
        return $categories;
	}
	function findOneByName($categoryName)
    {
        $conn = $this->databaseConnection->getConnection();
        $stmt = $conn->prepare("SELECT * FROM categories WHERE category_name = :category_name LIMIT 1");
        $stmt->execute([
            'category_name'=>$categoryName
        ]);
        $category = $stmt->fetch(PDO::FETCH_OBJ);
        $conn = null; 
        if($category == null) return $this->returnNullStatment();
        return $category;

    }
	function addCategoryUuidToProduct(Category $c) {
        $conn = $this->databaseConnection->getConnection();
        $stmt = $conn->prepare(
            "INSERT INTO product_category (uuid, category_uuid, product_uuid, created_at, updated_at)
            VALUES (:uuid, :category_uuid, :product_uuid, :created_at, :updated_at)"
        );
        $stmt->execute([
            'uuid'=>uuid::uuid4(),
            'category_uuid'=>$c->getUuid(),
            'product_uuid'=>$c->getProductUuid(),
            'created_at'=> date ('Y-m-d H:i:s'),
            'updated_at'=> date ('Y-m-d H:i:s')

        ]);
        $conn = null;
	}
    function findAllByProductUuid($uuid){
        $conn = $this->databaseConnection->getConnection();
        $stmt = $conn->prepare(
            "SELECT c.uuid, c.category_name, c.created_at, c.updated_at FROM categories as c
            INNER JOIN product_category as pc
                ON pc.category_uuid = c.uuid
            WHERE product_uuid = :product_uuid"
        );
        $stmt->execute([
            'product_uuid' => $uuid
        ]);
        $categories = $stmt->fetchAll(PDO::FETCH_OBJ);
        $conn = null;
        if($categories == null) return $this->returnManyNullStatment();
        return $categories;
    }
    function deleteCategoryByProductUuid($uuid)
    {
        $conn = $this->databaseConnection->getConnection();
        $stmt = $conn->prepare(
            "DELETE FROM product_category WHERE product_uuid = :uuid"
        );
        $stmt->execute([
            'uuid'=>$uuid
        ]);
        $conn = null;

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
    private function returnManyNullStatment(){
        $categories = array();
        $category = new stdClass();
        $category->uuid = null;
        $category->category_name = null;
        $category->created_at = null;
        $category->updated_at = null;
        $categories[] = $category;
        return $categories;
    }

}