<?php
require "./vendor/autoload.php";
class NullComment implements CommentInterface {
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

    function isNull(){
        return true;
    }

}