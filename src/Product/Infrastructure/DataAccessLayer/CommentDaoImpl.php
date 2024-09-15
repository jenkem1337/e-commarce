<?php

class CommentDaoImpl implements CommentDao {
    protected DatabaseConnection $dbConnection;

    function __construct(DatabaseConnection $dbConn)
    {
        $this->dbConnection = $dbConn;
    }
	function persist(Comment $c) {
        $conn = $this->dbConnection->getConnection();
        $stmt = $conn->prepare(
            "INSERT INTO comment (uuid, comment_text, user_uuid, product_uuid, created_at, updated_at)
             VALUES (:uuid, :comment_text, :user_uuid, :product_uuid, :created_at, :updated_at)"
        );
        $stmt->execute([
            'uuid'=>$c->getUuid(),
            'comment_text' => $c->getComment(),
            'user_uuid'=>$c->getUserUuid(),
            'product_uuid'=>$c->getProductUuid(),
            'created_at'=> $c->getCreatedAt(),
            'updated_at'=>$c->getUpdatedAt()
        ]);
        $conn=null;
	}
	
	function deleteByUuid($uuid) {
        $conn = $this->dbConnection->getConnection();
        $stmt = $conn->prepare(
            "DELETE FROM comment WHERE uuid = :uuid"
        );
        $stmt->execute([
            'uuid'=>$uuid
        ]);
        $conn=null; 
	}
		
	function findAll() {
        $conn = $this->dbConnection->getConnection();
        $stmt = $conn->prepare(
            "SELECT * FROM comment ORDER BY created_at DESC"
        );
        $stmt->execute();
        $comments = $stmt->fetchAll(PDO::FETCH_OBJ);
        $conn = null;
        if($comments == null) return $this->returnManyNullStatement();
        return $comments;
	}
	
	function findOneByUuid($uuid) {
        $conn = $this->dbConnection->getConnection();
        $stmt = $conn->prepare(
            "SELECT * FROM comment WHERE uuid = :uuid LIMIT 1"
        );
        $stmt->execute([
            'uuid'=>$uuid
        ]);
        $comment = $stmt->fetch(PDO::FETCH_OBJ);
        if($comment == null) return $this->returnNullStatment();
        return $comment;
	}
	
	function updateByUuid(Comment $c) {
        $conn = $this->dbConnection->getConnection();
        $stmt = $conn->prepare(
            "UPDATE comment SET comment_text = :comment_text, updated_at = NOW() WHERE uuid = :uuid"
        );
        $stmt->execute([
            'uuid'=>$c->getUuid(),
            'comment_text'=>$c->getComment()
        ]);
        $conn = null;
	}

    function findAllByProductUuid($productUuid){
        $conn = $this->dbConnection->getConnection();
        $stmt = $conn->prepare(
            "SELECT * FROM comment WHERE product_uuid = :product_uuid"
        );
        $stmt->execute([
            'product_uuid'=> $productUuid
        ]);
        $comments = $stmt->fetchAll(PDO::FETCH_OBJ);
        $conn = null;
        if($comments == null) return $this->returnManyNullStatement();
        return $comments;
    }
    function findAllByUserUuid($userUuid){
        $conn = $this->dbConnection->getConnection();
        $stmt = $conn->prepare(
            "SELECT * FROM comment WHERE user_uuid = :user_uuid"
        );
        $stmt->execute([
            'user_uuid'=> $userUuid
        ]);
        $comments = $stmt->fetchAll(PDO::FETCH_OBJ);
        $conn = null;
        if($comments == null) return $this->returnManyNullStatement();
        return $comments;

    }
    private function returnNullStatment() {
        $arr = [
            'uuid'=>null,
            'comment_text' => null,
            'user_uuid'=>null, 
            'product_uuid'=>null,
            'created_at'=>null,
            'updated_at'=>null,
        ];
        return json_decode(json_encode($arr),false);
    } 
    private function returnManyNullStatement(){
        $commentArr = array();
        $commentObj = new  stdClass();
        $commentObj->uuid = null;
        $commentObj->comment_text = null;
        $commentObj->user_uuid = null;
        $commentObj->product_uuid = null;
        $commentObj->created_at = null;
        $commentObj->updated_at = null;

        $commentArr[] = $commentObj;
        return $commentArr;
    }

}