<?php

class OrderDaoImpl extends AbstractDataAccessObject implements OrderDao{
    private DatabaseConnection $databaseConnection;
    function __construct($databaseInterface) {
        $this->databaseConnection = $databaseInterface;
        parent::__construct($this->databaseConnection);
    }
    
    function findOneByUuid($uuid) {
        $conn =  $this->databaseConnection->getConnection();
        $stmt = $conn->prepare("SELECT * FROM orders WHERE uuid = :uuid LIMIT 1");
        $stmt->execute([
            "uuid" => $uuid
        ]);
        $order = $stmt->fetch(PDO::FETCH_OBJ);
        $conn = null;
        if($order == null) return $this->returnNullStatement();

        return $order; 
    }

    function findAllItemsByOrderUuid($orderUuid) {
        $conn =  $this->databaseConnection->getConnection();
        $stmt = $conn->prepare(
            "SELECT * FROM order_items WHERE order_uuid = :uuid");
        $stmt->execute([
            "uuid" => $orderUuid
        ]);
        $order = $stmt->fetchAll(PDO::FETCH_OBJ);
        $conn = null;
        if($order == null) return $this->returnManyNullStatement();
        return $order; 
    }
    function findAllByUserUuid($userUuid){
        $conn =  $this->databaseConnection->getConnection();
        $stmt = $conn->prepare("SELECT * FROM orders WHERE user_uuid = :user_uuid");
        $stmt->execute([
            "user_uuid" => $userUuid
        ]);
        $order = $stmt->fetchAll(PDO::FETCH_OBJ);
        $conn = null;
        if($order == null) return $this->returnNullStatement();

        return $order; 

    }
    private function returnNullStatement() {
        $nullOrder = new stdClass();
        $nullOrder->uuid = null;
        $nullOrder->user_uuid = null;
        $nullOrder->payment_uuid = null;
        $nullOrder->shipment_uuid = null;
        $nullOrder->amount = null;
        $nullOrder->status = null;
        $nullOrder->created_at = null;
        $nullOrder->updated_at = null;
    } 
    private function returnManyNullStatement(){
        $nullOrder = new stdClass();
        $nullOrder->uuid = null;
        $nullOrder->user_uuid = null;
        $nullOrder->payment_uuid = null;
        $nullOrder->shipment_uuid = null;
        $nullOrder->amount = null;
        $nullOrder->status = null;
        $nullOrder->created_at = null;
        $nullOrder->updated_at = null;
        return [$nullOrder];
    }
}