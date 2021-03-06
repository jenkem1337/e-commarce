<?php
require './vendor/autoload.php';

class ProductDaoImpl implements ProductDao {
    protected SingletonConnection $dbConnection;
	function __construct(SingletonConnection $dbConnection) {
        $this->dbConnection = $dbConnection;
	}
	function persist(Product $p) {
        $conn = $this->dbConnection->getConnection();
        $stmt = $conn->prepare(
            "INSERT INTO products (uuid, brand, model, header, _description, price, prev_price, rate, stockquantity, created_at, updated_at)
            VALUES (:uuid, :brand, :model, :header, :_description, :price, :prev_price, :rate, :stockquantity, :created_at, :updated_at)"
        );
        $stmt->execute([
            'uuid'=>$p->getUuid(),
            'brand'=>$p->getBrand(),
            'model'=>$p->getModel(),
            'header'=>$p->getHeader(),
            '_description'=>$p->getPrice(),
            'price'=>$p->getPrice(),
            'prev_price'=>NULL,
            'rate'=>$p->getAvarageRate(),
            'stockquantity'=>$p->getStockQuantity(),
            'created_at'=>$p->getCreatedAt(),
            'updated_at'=>$p->getUpdatedAt()
        ]);
        $conn = null;
	}
    function persistSubscriber(ProductSubscriber $ps)
    {
        $conn = $this->dbConnection->getConnection();
        $stmt = $conn->prepare(
            "INSERT INTO product_subscriber (uuid, user_uuid, product_uuid, created_at, updated_at)
            VALUES (:uuid, :user_uuid, :product_uuid, :created_at, :updated_at)"
        );
        $stmt->execute([
            'uuid'=>$ps->getUuid(),
            'user_uuid'=>$ps->getUserUuid(),
            'product_uuid'=>$ps->getProductUuid(),
            'created_at'=>$ps->getCreatedAt(),
            'updated_at'=>$ps->getUpdatedAt()
        ]);
        $conn = null;

    }
	
	function deleteSubscriberByUserUuid($uuid)
    {
        $conn = $this->dbConnection->getConnection();
        $stmt = $conn->prepare(
            "DELETE FROM product_subscriber WHERE user_uuid = :uuid"
        );
        $stmt->execute([
            'uuid'=>$uuid
        ]);
        $conn = null;

    }
	function deleteByUuid($uuid) {
        $conn = $this->dbConnection->getConnection();
        $stmt = $conn->prepare(
            "DELETE FROM products WHERE uuid = :uuid"
        );
        $stmt->execute([
            'uuid'=>$uuid
        ]);
        $conn = null;
	}
	function findAll(){
        $conn =  $this->dbConnection->getConnection();
        $stmt = $conn->prepare("SELECT * FROM products ORDER BY created_at DESC");
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_OBJ);
        $conn = null;
        return $products; 

    }
    function findSubscriberByUserUuid($uuid)
    {
        $conn =  $this->dbConnection->getConnection();
        $stmt = $conn->prepare("SELECT * FROM product_subscriber WHERE user_uuid = :uuid LIMIT 1");
        $stmt->execute([
            'uuid'=>$uuid
        ]);
        $product = $stmt->fetch(PDO::FETCH_OBJ);
        $conn = null;
        if($product == null) return $this->returnNullStatment();
        return $product;

    }
	function findAllWithPagination($startingLimit, $perPageForUsers) {
        $conn =  $this->dbConnection->getConnection();
        $stmt = $conn->prepare("SELECT * FROM products ORDER BY created_at DESC LIMIT $startingLimit, $perPageForUsers");
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_OBJ);
        $conn = null;
        return $products; 

	}
	
	
	function findOneByUuid($uuid) {
        $conn =  $this->dbConnection->getConnection();
        $stmt = $conn->prepare("SELECT * FROM products WHERE uuid = :uuid LIMIT 1");
        $stmt->execute([
            'uuid'=>$uuid
        ]);
        $product = $stmt->fetch(PDO::FETCH_OBJ);
        $conn = null;
        if($product == null) return $this->returnNullStatment();
        return $product;
	}
	
	function findBySearching($value) {
        $conn = $this->dbConnection->getConnection();
        $stmt = $conn->prepare(
            "SELECT * FROM products WHERE (
                model LIKE :_value OR
                brand LIKE :_value OR
                _description LIKE :_value OR
                header LIKE :_value 
            )"    
        );
        $stmt->execute([
            '_value'=>"%".$value."%"
        ]);
        $products = $stmt->fetchAll(PDO::FETCH_OBJ);
        $conn = null;
        return $products;
	}
	
	function updateStockQuantityByUuid(Product $p) {
        $conn = $this->dbConnection->getConnection();
        $stmt = $conn->prepare(
            "UPDATE products SET stockquantity = :stockquantity, updated_at = NOW()
            WHERE uuid = :uuid"
        );
        $stmt->execute([
            'uuid'=>$p->getUuid(),
            'stockquantity'=>$p->getStockQuantity()
        ]);
        $conn = null;

	}
	
	function updateModelNameByUuid(Product $p) {
        $conn = $this->dbConnection->getConnection();
        $stmt = $conn->prepare(
            "UPDATE products SET model = :model, updated_at = NOW()
            WHERE uuid = :uuid"
        );
        $stmt->execute([
            'uuid'=>$p->getUuid(),
            'model'=>$p->getModel()
        ]);
        $conn = null;

	}
	
	function updateBrandNameByUuid(Product $p) {        
        $conn = $this->dbConnection->getConnection();
        $stmt = $conn->prepare(
            "UPDATE products SET brand = :brand, updated_at = NOW()
            WHERE uuid = :uuid"
        );
        $stmt->execute([
            'uuid'=>$p->getUuid(),
            'brand'=>$p->getBrand()
        ]);
        $conn = null;

	}
	
	function updatePriceByUuid(Product $p) {
        $conn = $this->dbConnection->getConnection();
        $stmt = $conn->prepare(
            "UPDATE products SET price = :price, prev_price = :prev_price, updated_at = NOW()
            WHERE uuid = :uuid"
        );
        $stmt->execute([
            'uuid'=>$p->getUuid(),
            'price'=>$p->getStockQuantity(),
            'prev_price'=>$p->getPreviousPrice()
        ]);
        $conn = null;

	}
	function updateDescriptionByUuid(Product $p) {
        $conn = $this->dbConnection->getConnection();
        $stmt = $conn->prepare(
            "UPDATE products SET _description = :_description, updated_at = NOW()
            WHERE uuid = :uuid"
        );
        $stmt->execute([
            'uuid'=>$p->getUuid(),
            '_description'=>$p->getDescription()
        ]);
        $conn = null;

	}
	
	function updateHeaderByUuid(Product $p) {
        $conn = $this->dbConnection->getConnection();
        $stmt = $conn->prepare(
            "UPDATE products SET header = :header, updated_at = NOW()
            WHERE uuid = :uuid"
        );
        $stmt->execute([
            'uuid'=>$p->getUuid(),
            'header'=>$p->getHeader()
        ]);
        $conn = null;


	}
	
	function updateAvarageRateByUuid(Product $p) {
        $conn = $this->dbConnection->getConnection();
        $stmt = $conn->prepare(
            "UPDATE products SET rate = :rate, updated_at = NOW()
            WHERE uuid = :uuid"
        );
        $stmt->execute([
            'uuid'=>$p->getUuid(),
            'rate'=>$p->getAvarageRate()
        ]);
        $conn = null;
	}
    private function returnNullStatment() {
        $arr = [
            'uuid'=>null,
            'brand' => null,
            'model'=>null, 
            'header'=>null,
            '_description'=>null,
            'price'=>null,
            'prev_price'=>null,
            'rate'=>null,
            'stockquantity'=>null,
            'created_at'=>null,
            'updated_at'=>null,
        ];
        return json_decode(json_encode($arr),false);
    } 

}