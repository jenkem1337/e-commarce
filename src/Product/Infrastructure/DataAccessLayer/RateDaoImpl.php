<?php

class RateDaoImpl implements RateDao {
    protected DatabaseConnection $dbConnection;
	function __construct(DatabaseConnection $dbConn) {
        $this->dbConnection = $dbConn;
	}
	function persist(Rate $r) {
        $conn = $this->dbConnection->getConnection();
        $stmt = $conn->prepare(
            "INSERT INTO rates (uuid, rate_num, product_uuid, user_uuid, created_at, updated_at)
            VALUES (:uuid, :rate_num, :product_uuid, :user_uuid, :created_at, :updated_at)"
        );
        $stmt->execute([
            'uuid'=>$r->getUuid(),
            'rate_num'=>$r->getRateNumber(),
            'product_uuid'=>$r->getPruductUuid(),
            'user_uuid'=>$r->getUserUuid(),
            'created_at'=>$r->getCreatedAt(),
            'updated_at'=>$r->getUpdatedAt()
        ]);
        $conn = null;
	}
	
	/**
	 *
	 * @param mixed $uuid
	 *
	 * @return mixed
	 */
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
	
	/**
	 *
	 * @param Rate $r
	 *
	 * @return mixed
	 */
	function updateRateNumberByUuid(Rate $r) {
        $conn = $this->dbConnection->getConnection();
        $stmt = $conn->prepare(
            "UPDATE rates SET rate_num = :rate_num, updated_at = NOW()
            WHERE uuid = :uuid"
        );
        $stmt->execute([
            'uuid'=>$r->getUuid(),
            'rate_num'=>$r->getRateNumber()
        ]);
        $conn = null;
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