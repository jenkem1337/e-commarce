<?php
require './vendor/autoload.php';
class CategoryInMemoryDaoImpl extends CategoryDaoImpl{
    function __construct(DatabaseConnection $dbConn)
    {
        parent::__construct($dbConn);
        $this->createTable();
                                    
    }
    private function createTable(){
        $conn = $this->databaseConnection->getConnection();
        $conn->exec(
            "CREATE TABLE IF NOT EXISTS category (
                uuid TEXT PRIMARY KEY, 
                category_name TEXT, 
                created_at DATETIME,
                updated_at DATETIME)"
            );
            $conn = null;
    }
}   