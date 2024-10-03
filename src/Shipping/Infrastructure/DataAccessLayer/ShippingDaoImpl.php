<?php

class ShippingDaoImpl extends AbstractDataAccessObject implements ShippingDao {
    private DatabaseConnection $databaseConnection;
    function __construct(DatabaseConnection $dbConn)
    {
        $this->databaseConnection = $dbConn;
        parent::__construct($this->databaseConnection);
    }
    function findAll()
    {
        $conn = $this->databaseConnection->getConnection();
        $stmt = $conn->prepare("SELECT * FROM shipping");
        $stmt->execute();
        $shippings = $stmt->fetchAll(PDO::FETCH_OBJ);
        $conn=null;
        if(!$shippings) return $this->returnManyNullStatement();
        return $shippings;
    }
    function findOneByUuid($uuid)
    {
        $conn = $this->databaseConnection->getConnection();
        $stmt = $conn->prepare(
            "SELECT * FROM shipping
             WHERE uuid = :uuid"
        );
        $stmt->execute([
            'uuid' => $uuid
        ]);
        $shipping = $stmt->fetch(PDO::FETCH_OBJ);
        $conn=null;
        if(!$shipping) return $this->returnNullStatement();
        return $shipping;
    }
    private function returnManyNullStatement(){
        $shippings = array();
        $shippingObj = new stdClass;
        $shippingObj->uuid = null;
        $shippingObj->shiping_type = null;
        $shippingObj->price = null;
        $shippingObj->created_at = null;
        $shippingObj->updated_at = null;
        $shippings[] = $shippingObj;
        return $shippings;
    }
    private function returnNullStatement(){
        $shippingObj = new stdClass;
        $shippingObj->uuid = null;
        $shippingObj->shiping_type = null;
        $shippingObj->price = null;
        $shippingObj->created_at = null;
        $shippingObj->updated_at = null;
        return $shippingObj;
    }
}