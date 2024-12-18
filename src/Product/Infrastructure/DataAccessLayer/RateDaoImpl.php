<?php

class RateDaoImpl implements RateDao {
    protected DatabaseConnection $dbConnection;
	function __construct(DatabaseConnection $dbConn) {
        $this->dbConnection = $dbConn;
	}

    function findOneByProductUuidAndUserUuid($productUuid, $userUuid){
        $conn = $this->dbConnection->getConnection();
        $stmt = $conn->prepare(
            "SELECT * FROM rates WHERE product_uuid = :product_uuid AND user_uuid = :user_uuid LIMIT 1"
        );
        $stmt->execute([
            'product_uuid'=>$productUuid,
            'user_uuid' => $userUuid
        ]);
        $rate = $stmt->fetch(PDO::FETCH_OBJ);
        $conn = null;
        if($rate ==null) return $this->returnNullStatment();
        return $rate;

    }

    function findOneByUuid($uuid) {
        $conn = $this->dbConnection->getConnection();
        $stmt = $conn->prepare(
            "SELECT * FROM rates WHERE uuid = :uuid LIMIT 1"
        );
        $stmt->execute([
            'uuid'=>$uuid
        ]);
        $rate = $stmt->fetch(PDO::FETCH_OBJ);
        $conn = null;
        if($rate ==null) return $this->returnNullStatment();
        return $rate;
	}
	
	/**
	 *
	 * @return mixed
	 */
	function findAll() {
        $conn = $this->dbConnection->getConnection();
        $stmt = $conn->prepare(
            "SELECT * FROM rates ORDER BY created_at DESC"
        );
        $stmt->execute();
        $rates = $stmt->fetchAll(PDO::FETCH_OBJ);
        $conn = null;
        if($rates == null) return $this->returnManyNullStatement();

        return $rates;

	}
	
	function findAllByProductUuid($pUuid)
    {
        $conn = $this->dbConnection->getConnection();
        $stmt = $conn->prepare(
            "SELECT * FROM rates WHERE product_uuid = :product_uuid"
        );
        $stmt->execute([
            "product_uuid" => $pUuid
        ]);
        $rates = $stmt->fetchAll(PDO::FETCH_OBJ);
        $conn = null;
        if($rates == null) return $this->returnManyNullStatement();

        return $rates;


    }
	function deleteRateByUuid($uuid) {
        $conn = $this->dbConnection->getConnection();
        $stmt = $conn->prepare(
            "DELETE FROM rates WHERE uuid = :uuid"
        );
        $stmt->execute([
            'uuid'=>$uuid
        ]);
	}

    function deleteAllByProductUuid($productUuid){
        $conn = $this->dbConnection->getConnection();
        $stmt = $conn->prepare(
            "DELETE FROM rates WHERE product_uuid = :product_uuid"
        );
        $stmt->execute([
            'product_uuid'=>$productUuid
        ]);
    }

    private function returnNullStatment() {
        $arr = [
            'uuid'=>null,
            'rate_num' => null,
            'user_uuid'=>null, 
            'product_uuid'=>null,
            'created_at'=>null,
            'updated_at'=>null,
        ];
        return json_decode(json_encode($arr),false);
    } 
    private function returnManyNullStatement(){
        $rateArr= array();
        $rate= new stdClass();
        $rate->uuid = null;
        $rate->rate_num = null;
        $rate->user_uuid = null;
        $rate->product_uuid = null;
        $rate->created_at  = null;
        $rate->updated_at = null;
        $rateArr[] = $rate;
        return $rateArr;
    }

}