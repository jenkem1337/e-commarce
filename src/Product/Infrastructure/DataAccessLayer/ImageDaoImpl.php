<?php

class ImageDaoImpl implements ImageDao {
    protected DatabaseConnection $dbConnection;

	function __construct(DatabaseConnection $dbConnection) {
	    $this->dbConnection = $dbConnection;
	}
    function persist(Image $i)
    {
        $conn = $this->dbConnection->getConnection();
        $stmt = $conn->prepare(
            "INSERT INTO image (uuid, image_name, product_uuid, created_at, updated_at) 
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
            "DELETE FROM image WHERE uuid = :uuid"
        );
        $stmt->execute([
            'uuid'=>$uuid
        ]);
        $conn= null;
    }

    function deleteAllByProductUuid($productUuid) {
        $conn = $this->dbConnection->getConnection();
        $stmt = $conn->prepare(
            "DELETE FROM image WHERE product_uuid = :product_uuid"
        );
        $stmt->execute([
            'product_uuid'=>$productUuid
        ]);
        $conn= null;
    }
    function findAll()
    {
        $conn= $this->dbConnection->getConnection();
        $stmt = $conn->prepare(
            "SELECT * FROM image ORDER BY created_at DESC"
        );
        $stmt->execute();
        $images = $stmt->fetchAll(PDO::FETCH_OBJ);
        $conn = null;
        if($images == null) return $this->returnManyNullStatement();
        return $images;
    }
    function findOneByUuid($uuid)
    {
        $conn= $this->dbConnection->getConnection();
        $stmt = $conn->prepare(
            "SELECT * FROM image WHERE uuid = :uuid"
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
            "SELECT * FROM image WHERE product_uuid = :uuid"
        );
        $stmt->execute([
            'uuid'=>$pUuid
        ]);
        $image = $stmt->fetch(PDO::FETCH_OBJ);
        $conn=null;
        if($image == null) return $this->returnNullStatment();
        return $image;

    }
    function findAllByProductUuid($pUuid)
    {
        $conn= $this->dbConnection->getConnection();
        $stmt = $conn->prepare(
            "SELECT * FROM image WHERE product_uuid = :uuid "
        );
        $stmt->execute([
            'uuid'=>$pUuid
        ]);
        $images = $stmt->fetchAll(PDO::FETCH_OBJ);
        $conn=null;
        if($images == null) return $this->returnManyNullStatement();
        return $images;

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
    private function returnManyNullStatement(){
        $imageArr = array();
        $imageObj= new stdClass();
        $imageObj->uuid = null;
        $imageObj->image_name = null;
        $imageObj->product_uuid = null;
        $imageObj->created_at = null;
        $imageObj->updated_at = null;
        $imageArr[] = $imageObj;
        return $imageArr;
    }
}