<?php
require './vendor/autoload.php';

class CommentDaoImpl implements CommentDao {
    private DatabaseConnection $dbConnection;

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
            "SELECT * FROM comment"
        );
        $stmt->execute();
        $comments = $stmt->fetchAll(PDO::FETCH_OBJ);
        $conn = null;
        if($comments == null) return $this->returnNullStatment();
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
	
	function updateByUuid($uuid, $updatedComment) {
        $conn = $this->dbConnection->getConnection();
        $stmt = $conn->prepare(
            "UPDATE comment SET comment_text = :comment_text, updated_at = NOW() WHERE uuid = :uuid"
        );
        $stmt->execute([
            'uuid'=>$uuid,
            'comment_text'=>$updatedComment
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
        if($comments == null) return $this->returnNullStatment();
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

}