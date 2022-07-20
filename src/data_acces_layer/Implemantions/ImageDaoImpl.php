<?php
require './vendor/autoload.php';

class ImageDaoImpl implements ImageDao {
    protected SingletonConnection $dbConnection;

	function __construct(SingletonConnection $dbConnection) {
	    $this->dbConnection = $dbConnection;
        $this->dbConnection->createDatabaseConnection();

	}
    function persist(Image $i)
    {
        $conn = $this->dbConnection->getConnection();
        $stmt = $conn->prepare(
            "INSERT INTO 'image' (uuid, image_name, product_uuid, created_at, updated_at) 
            VALUES (:uuid, :image_name, :product_uuid, :created_at, :updated_at)"
        );
        $stmt->execute([
            'uuid'=>$i->getUuid(),
            'image_name'=>$i->getImageName(),
            'product_uuid'=>$i->getProductUuid(),
            'created_at'=>$i->getCreatedAt(),
            'updated_at'=>$i->getUpdatedAt()
        ]);
        $conn = null;
    }
    function deleteByUuid($uuid)
    {
        $conn = $this->dbConnection->getConnection();
        $stmt = $conn->prepare(
            "DELETE FROM 'image' WHERE uuid = :uuid"
        );
        $stmt->execute([
            'uuid'=>$uuid
        ]);
        $con= null;
    }
    function findAll()
    {
        $conn= $this->dbConnection->getConnection();
        $stmt = $conn->prepare(
            "SELECT * FROM 'image' ORDER BY created_at DESC"
        );
        $stmt->execute();
        $images = $stmt->fetchAll(PDO::FETCH_OBJ);
        $con = null;
        return $images;
    }
    function findOneByUuid($uuid)
    {
        $conn= $this->dbConnection->getConnection();
        $stmt = $conn->prepare(
            "SELECT * FROM 'image' WHERE uuid = :uuid"
        );
        $stmt->execute([
            'uuid'=>$uuid
        ]);
        $image = $stmt->fetch(PDO::FETCH_OBJ);
        $conn=null;
        if($image == null) return $this->returnNullStatment();
        return $image;

    }
    function findImageByProductUuid($pUuid)
    {
        $conn= $this->dbConnection->getConnection();
        $stmt = $conn->prepare(
            "SELECT * FROM 'image' WHERE product_uuid = :uuid"
        );
        $stmt->execute([
            'uuid'=>$pUuid
        ]);
        $image = $stmt->fetch(PDO::FETCH_OBJ);
        $conn=null;
        if($image == null) return $this->returnNullStatment();
        return $image;

    }
    private function returnNullStatment() {
        $arr = [
            'uuid'=>null,
            'image_name' => null,
            'product_uuid'=>null,
            'created_at'=>null,
            'updated_at'=>null,
        ];
        return json_decode(json_encode($arr),false);
    } 

}