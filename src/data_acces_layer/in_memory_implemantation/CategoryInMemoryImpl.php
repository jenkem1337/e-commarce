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
    function updateNameByUuid($uuid, $newCategoryName) {
        $conn = $this->databaseConnection->getConnection();
        $stmt = $conn->prepare("UPDATE category SET category_name = :category_name, updated_at=DATE('now') WHERE uuid = :uuid");
        $stmt->execute([
             'category_name'=>$newCategoryName,
             'uuid'=> $uuid
        ]);
        $conn = null;
	}

}   