<?php

class PaymentDaoImpl extends AbstractDataAccessObject implements PaymentDao {
    private DatabaseConnection $databaseConnection;

    function __construct($databaseInterface){
        $this->databaseConnection = $databaseInterface;
        parent::__construct($this->databaseConnection);
    }
    function findOneByUuid($uuid) {
        $conn =  $this->databaseConnection->getConnection();
        $stmt = $conn->prepare("SELECT * FROM payments WHERE uuid = :uuid LIMIT 1");
        $stmt->execute([
            "uuid" => $uuid
        ]);
        $payment = $stmt->fetch(PDO::FETCH_OBJ);
        $conn = null;
        if($payment == null) return $this->returnNullStatement();
        return $payment; 
    }

    private function returnNullStatement(){
        $obj = new stdClass();
        $obj->uuid = null;
        $obj->user_uuid = null;
        $obj->amount = null;
        $obj->method = null;
        $obj->status = null;
        $obj->created_at = null;
        $obj->updated_at = null;
    }
}