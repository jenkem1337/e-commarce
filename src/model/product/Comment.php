<?php
class Comment extends BaseEntity{
    private $productUuid;
    private $userUuid;
    private $comment;
    
    function __construct($uuid, $productUuid, $userUuid, $comment, $createdAt, $updatedAt)
    {
        parent::__construct($uuid, $createdAt, $updatedAt);
        if(!$userUuid){
            throw new NullException('user uuid');
        }
        if(!$productUuid){
            throw new NullException('product uuid');
        }
        if(!$comment){
            throw new NullException('comment');
        }
        if(strlen($comment) < 0) {
            throw new NegativeValueException();
        }
        $this->userUuid = $userUuid;
        $this->productUuid= $productUuid;
        $this->comment = $comment;
    }

    function changeComment($comment){
        if(!$comment){
            throw new NullException('comment');
        }
        if(strlen($comment) < 0) {
            throw new NegativeValueException();
        }
        $this->comment = $comment;
    }
    /**
     * Get the value of productUuid
     */ 
    public function getProductUuid()
    {
        return $this->productUuid;
    }

    /**
     * Get the value of userUuid
     */ 
    public function getUserUuid()
    {
        return $this->userUuid;
    }

    /**
     * Get the value of comment
     */ 
    public function getComment()
    {
        return $this->comment;
    }
}