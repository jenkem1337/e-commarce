<?php
class NullComment implements CommentInterface, NullEntityInterface {
    function __construct()
    {
        
    }
    function changeComment($comment){}
    
    public function getProductUuid(){}

    public function getUserUuid(){}

    public function getComment(){}

    public function getUuid(){}
    function setWriterName($writerName){}
    function getWriterName(){}

    public function getCreatedAt(){}

    public function getUpdatedAt(){}

    function isNull():bool{
        return true;
    }

}