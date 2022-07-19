<?php

require './vendor/autoload.php';

class ProductInMemoryDaoImpl extends ProductDaoImpl {
    function __construct(DatabaseConnection $dbConn)
    {
        parent::__construct($dbConn);
        $this->createProductTable();
    }

    private function createProductTable(){
        $this->dbConnection->getConnection()
                            ->exec(
                                "CREATE TABLE IF NOT EXISTS products (
                                    uuid TEXT PRIMARY KEY,
                                    brand TEXT,
                                    model TEXT,
                                    header TEXT,
                                    _description TEXT,
                                    price FLOAT,
                                    prev_price FLOAT,
                                    rate FLOAT,
                                    stockquantity INTEGER,
                                    created_at DATETIME,
                                    updated_at DATETIME
                                )"
                            );
    }
    function updateStockQuantityByUuid(Product $p) {
        $conn = $this->dbConnection->getConnection();
        $stmt = $conn->prepare(
            "UPDATE products SET stockquantity = :stockquantity, updated_at = DATE('now')
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
            "UPDATE products SET model = :model, updated_at = DATE('now')
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
            "UPDATE products SET brand = :brand, updated_at = DATE('now')
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
            "UPDATE products SET price = :price, prev_price = :prev_price, updated_at = DATE('now')
            WHERE uuid = :uuid"
        );
        $stmt->execute([
            'uuid'=>$p->getUuid(),
            'price'=>$p->getPrice(),
            'prev_price'=>$p->getPreviousPrice()
        ]);
        $conn = null;

	}
	function updateDescriptionByUuid(Product $p) {
        $conn = $this->dbConnection->getConnection();
        $stmt = $conn->prepare(
            "UPDATE products SET _description = :_description, updated_at = DATE('now')
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
            "UPDATE products SET header = :header, updated_at = DATE('now')
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
            "UPDATE products SET rate = :rate, updated_at = DATE('now')
            WHERE uuid = :uuid"
        );
        $stmt->execute([
            'uuid'=>$p->getUuid(),
            'rate'=>$p->getAvarageRate()
        ]);
        $conn = null;
	}

}