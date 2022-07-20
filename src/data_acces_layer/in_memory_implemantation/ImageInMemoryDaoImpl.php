<?php
require './vendor/autoload.php';

class ImageInMemoryDaoImpl extends ImageDaoImpl {
    function __construct(DatabaseConnection $conn)
    {
        parent::__construct($conn);
        $this->createProductTable();
        $this->createImageTable();
    }
    private function createImageTable(){
        $this->dbConnection->getConnection()
        ->exec(
            "CREATE TABLE IF NOT EXISTS 'image' (
                uuid TEXT PRIMARY KEY,
                image_name TEXT,
                product_uuid TEXT,
                created_at DATETIME,
                updated_at DATETIME,
                FOREIGN KEY (product_uuid)
                    REFERENCES products(uuid)
                    ON DELETE CASCADE
                    ON UPDATE CASCADE
            )"
        );

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
}